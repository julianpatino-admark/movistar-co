# Manual administrative job. Deploying the application never executes this job.
# Running it deliberately sets the account password to the mounted secret value.
resource "google_cloud_run_v2_job" "movistar_monitor_user" {
  project             = "kn-co-cust-svc-movistar-prod"
  name                = "movistar-monitor-user"
  location            = "us-east1"
  deletion_protection = false

  template {
    task_count  = 1
    parallelism = 1

    template {
      service_account = google_service_account.movistar_cloud_build.email
      timeout         = "300s"
      max_retries     = 0

      vpc_access {
        network_interfaces {
          network    = "projects/kn-co-customers-host-prod/global/networks/vpc-co-prod-customers"
          subnetwork = "projects/kn-co-customers-host-prod/regions/us-east1/subnetworks/sn-co-cust-movistar-prod"
        }
        egress = "PRIVATE_RANGES_ONLY"
      }

      containers {
        image = local.movistar_runtime_image
        args = [
          "php", "artisan", "monitor:user", "julian.patino@konecta.com",
          "--name=Julián Patiño", "--password-file=/secrets/monitor/password", "--no-interaction",
        ]

        resources {
          limits = { cpu = "1", memory = "512Mi" }
        }

        dynamic "env" {
          for_each = {
            APP_ENV              = "production"
            APP_DEBUG            = "false"
            LOG_CHANNEL          = "stderr"
            DB_CONNECTION        = "mysql"
            DB_HOST              = local.movistar_database_host
            DB_PORT              = "3306"
            DB_DATABASE          = google_sql_database.movistar.name
            DB_USERNAME          = google_sql_user.runtime["application"].name
            CLOUD_SQL_PRIVATE_IP = data.google_sql_database_instance.movistar.private_ip_address
            MYSQL_ATTR_SSL_CA    = "/etc/ssl/cloudsql-server-ca.pem"
            TRACKING_DRIVER      = "config"
          }
          content {
            name  = env.key
            value = env.value
          }
        }

        dynamic "env" {
          for_each = {
            APP_KEY     = { secret = "laravel-app-key", version = "1" }
            DB_PASSWORD = { secret = "db-runtime-password", version = "2" }
          }
          content {
            name = env.key
            value_source {
              secret_key_ref {
                secret  = google_secret_manager_secret.movistar_runtime[env.value.secret].secret_id
                version = env.value.version
              }
            }
          }
        }

        volume_mounts {
          name       = "monitor-password"
          mount_path = "/secrets/monitor"
        }
      }

      volumes {
        name = "monitor-password"
        secret {
          secret = google_secret_manager_secret.movistar_runtime["monitor-initial-password"].secret_id
          items {
            version = "latest"
            path    = "password"
          }
        }
      }
    }
  }

  depends_on = [
    google_secret_manager_secret_iam_member.movistar_runtime_access["monitor-initial-password"],
    google_secret_manager_secret_iam_member.movistar_runtime_access["db-runtime-password"],
    google_secret_manager_secret_iam_member.movistar_runtime_access["laravel-app-key"],
  ]
}
