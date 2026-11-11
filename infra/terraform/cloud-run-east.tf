resource "google_cloud_run_v2_service" "movistar_landing_east" {
  project  = "kn-co-cust-svc-movistar-prod"
  name     = "movistar-landing"
  location = "us-east1"

  ingress              = "INGRESS_TRAFFIC_INTERNAL_LOAD_BALANCER"
  invoker_iam_disabled = true
  deletion_protection  = false

  # Configuración temporal para validar la landing sin Cloud SQL.
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
      image = "us-central1-docker.pkg.dev/kn-co-cust-svc-movistar-prod/movistar-landing/app@sha256:40bcec778d1a5efddff0ff2cd4fce2b92a75edc95c614a796b09d00770f462d3"

      # Preparamos SQLite antes de arrancar Apache sobre Alpine.
      command = ["/bin/sh"]
      args = [
        "-c",
        <<-EOT
          set -eu
          cd /var/www/html

          touch /tmp/movistar.sqlite

            chown apache:apache /tmp/movistar.sqlite
            chmod 660 /tmp/movistar.sqlite

            su -s /bin/sh apache -c \
                "php artisan migrate --force --no-interaction"

            exec /usr/sbin/httpd -DFOREGROUND
        EOT
      ]

      ports {
        container_port = 8080
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

      # Base de datos temporal de preview.
      env {
        name  = "DB_CONNECTION"
        value = "sqlite"
      }

      env {
        name  = "DB_DATABASE"
        value = "/tmp/movistar.sqlite"
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
    google_secret_manager_secret_iam_member.movistar_runtime_access["gocontact-base-url"],
    google_secret_manager_secret_iam_member.movistar_runtime_access["gocontact-username"],
    google_secret_manager_secret_iam_member.movistar_runtime_access["gocontact-password"],
    google_secret_manager_secret_iam_member.movistar_runtime_access["gocontact-database-id"],
    google_secret_manager_secret_iam_member.movistar_runtime_access["gocontact-monitor-username"],
    google_secret_manager_secret_iam_member.movistar_runtime_access["gocontact-monitor-password"]
  ]
}
