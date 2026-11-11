resource "google_cloud_run_v2_service" "movistar_landing" {
  project  = "kn-co-cust-svc-movistar-prod"
  name     = "movistar-landing"
  location = "us-central1"

  ingress              = "INGRESS_TRAFFIC_ALL"
  invoker_iam_disabled = true
  deletion_protection  = false

  scaling {
    max_instance_count = 1
  }

  template {
    service_account = google_service_account.movistar_cloud_build.email

    max_instance_request_concurrency = 20
    timeout                          = "300s"

    containers {
      image = local.movistar_runtime_image

      command = ["/bin/sh"]
      args = [
        "-c",
        <<-EOT
          set -eu
          touch /tmp/movistar.sqlite
          chown nginx:nginx /tmp/movistar.sqlite
          chmod 660 /tmp/movistar.sqlite
          su -s /bin/sh nginx -c "php artisan migrate --force --no-interaction"
          exec /usr/local/bin/movistar-entrypoint
        EOT
      ]

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
        name  = "TRACKING_DRIVER"
        value = "config"
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
        name = "APP_KEY"

        value_source {
          secret_key_ref {
            secret  = google_secret_manager_secret.movistar_runtime["laravel-app-key"].secret_id
            version = "1"
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
