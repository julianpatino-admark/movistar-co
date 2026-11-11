resource "google_cloud_run_v2_service" "movistar_landing_east" {
  project  = "kn-co-cust-svc-movistar-prod"
  name     = "movistar-landing"
  location = "us-east1"

  ingress              = "INGRESS_TRAFFIC_INTERNAL_LOAD_BALANCER"
  invoker_iam_disabled = true
  deletion_protection  = false

  scaling {
    max_instance_count = 1
  }

  template {
    service_account = google_service_account.movistar_cloud_build.email

    max_instance_request_concurrency = 20
    timeout                          = "300s"

    vpc_access {
      network_interfaces {
        network    = "projects/kn-co-customers-host-prod/global/networks/vpc-co-prod-customers"
        subnetwork = "projects/kn-co-customers-host-prod/regions/us-east1/subnetworks/sn-co-cust-movistar-prod"
      }

      egress = "PRIVATE_RANGES_ONLY"
    }

    containers {
      image = local.movistar_runtime_image

      ports {
        container_port = 8080
      }

      startup_probe {
        timeout_seconds   = 5
        period_seconds    = 5
        failure_threshold = 24

        http_get {
          path = "/health"
          port = 8080
        }
      }

      resources {
        limits = {
          cpu    = "1"
          memory = "512Mi"
        }
      }

      env {
        name  = "APP_NAME"
        value = "Movistar"
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
        name  = "APP_URL"
        value = "https://movistar-landing-fkgpi4yv5a-uc.a.run.app"
      }

      env {
        name  = "LOG_CHANNEL"
        value = "stderr"
      }

      env {
        name  = "LOG_LEVEL"
        value = "info"
      }

      env {
        name  = "SESSION_DRIVER"
        value = "cookie"
      }

      env {
        name  = "SESSION_SECURE_COOKIE"
        value = "true"
      }

      env {
        name  = "CACHE_DRIVER"
        value = "array"
      }

      env {
        name  = "QUEUE_CONNECTION"
        value = "sync"
      }

      env {
        name  = "FILESYSTEM_DISK"
        value = "local"
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
        name = "COBALT_LOGIN"

        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.movistar_runtime["cobalt-login"].secret_id
            version = "1"
          }
        }
      }

      env {
        name = "COBALT_PASSWORD"

        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.movistar_runtime["cobalt-password"].secret_id
            version = "2"
          }
        }
      }

      env {
        name = "GOCONTACT_BASE_URL"

        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.movistar_runtime["gocontact-base-url"].secret_id
            version = "latest"
          }
        }
      }

      env {
        name = "GOCONTACT_USERNAME"

        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.movistar_runtime["gocontact-username"].secret_id
            version = "latest"
          }
        }
      }

      env {
        name = "GOCONTACT_PASSWORD"

        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.movistar_runtime["gocontact-password"].secret_id
            version = "latest"
          }
        }
      }

      env {
        name = "GOCONTACT_DATABASE_ID"

        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.movistar_runtime["gocontact-database-id"].secret_id
            version = "latest"
          }
        }
      }

      env {
        name = "GOCONTACT_MONITOR_USERNAME"

        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.movistar_runtime["gocontact-monitor-username"].secret_id
            version = "latest"
          }
        }
      }

      env {
        name = "GOCONTACT_MONITOR_PASSWORD"

        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.movistar_runtime["gocontact-monitor-password"].secret_id
            version = "latest"
          }
        }
      }

      env {
        name  = "GOCONTACT_LOG_LEVEL"
        value = "info"
      }
    }
  }

  depends_on = [
    google_secret_manager_secret_iam_member.movistar_runtime_access["laravel-app-key"],
    google_secret_manager_secret_iam_member.movistar_runtime_access["db-app-password"],
    google_secret_manager_secret_iam_member.movistar_runtime_access["gocontact-base-url"],
    google_secret_manager_secret_iam_member.movistar_runtime_access["gocontact-username"],
    google_secret_manager_secret_iam_member.movistar_runtime_access["gocontact-password"],
    google_secret_manager_secret_iam_member.movistar_runtime_access["gocontact-database-id"],
    google_secret_manager_secret_iam_member.movistar_runtime_access["gocontact-monitor-username"],
    google_secret_manager_secret_iam_member.movistar_runtime_access["gocontact-monitor-password"]
  ]
}
