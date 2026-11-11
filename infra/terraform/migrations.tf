locals {
  movistar_database_host = trimsuffix(one([
    for dns in data.google_sql_database_instance.movistar.dns_names : dns.name
    if dns.connection_type == "PRIVATE_SERVICES_ACCESS"
  ]), ".")

  movistar_runtime_image = "us-central1-docker.pkg.dev/kn-co-cust-svc-movistar-prod/movistar-landing/app@sha256:32c76b70565f891ef43f95684b807d6ae93ffeb5533062aa4bf9d582e37dc64f"
}

resource "google_cloud_run_v2_job" "movistar_migrations" {
  project             = "kn-co-cust-svc-movistar-prod"
  name                = "movistar-migrations"
  location            = "us-east1"
  deletion_protection = false

  template {
    task_count  = 1
    parallelism = 1

    template {
      service_account = google_service_account.movistar_cloud_build.email
      timeout         = "600s"
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
        args  = ["php", "artisan", "migrate", "--force", "--no-interaction"]

        resources {
          limits = {
            cpu    = "1"
            memory = "512Mi"
          }
        }

        env {
          name  = "APP_ENV"
          value = "production"
        }

        env {
          name  = "APP_DEBUG"
          value = "false"
        }

        env {
          name  = "LOG_CHANNEL"
          value = "stderr"
        }

        env {
          name = "APP_KEY"
          value_source {
            secret_key_ref {
              secret  = google_secret_manager_secret.movistar_runtime["laravel-app-key"].secret_id
              version = "1"
            }
          }
        }

        env {
          name  = "DB_CONNECTION"
          value = "mysql"
        }

        env {
          name  = "DB_HOST"
          value = local.movistar_database_host
        }

        env {
          name  = "DB_PORT"
          value = "3306"
        }

        env {
          name  = "DB_DATABASE"
          value = google_sql_database.movistar.name
        }

        env {
          name  = "DB_USERNAME"
          value = google_sql_user.movistar.name
        }

        env {
          name = "DB_PASSWORD"
          value_source {
            secret_key_ref {
              secret  = google_secret_manager_secret.movistar_runtime["db-app-password"].secret_id
              version = "1"
            }
          }
        }

        env {
          name  = "CLOUD_SQL_PRIVATE_IP"
          value = data.google_sql_database_instance.movistar.private_ip_address
        }

        env {
          name  = "MYSQL_ATTR_SSL_CA"
          value = "/etc/ssl/cloudsql-server-ca.pem"
        }

        env {
          name  = "TRACKING_DRIVER"
          value = "config"
        }
      }
    }
  }

  depends_on = [
    google_secret_manager_secret_iam_member.movistar_runtime_access["db-app-password"],
    google_secret_manager_secret_iam_member.movistar_runtime_access["laravel-app-key"],
  ]
}
