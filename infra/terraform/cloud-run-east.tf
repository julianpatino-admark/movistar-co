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
      image = "us-central1-docker.pkg.dev/kn-co-cust-svc-movistar-prod/movistar-landing/app@sha256:e0567b99847ba56e1a94d1cf01c6afc7bdfe4dbd5c057c9685011268f606e144"

      # El ENTRYPOINT original docker-php-entrypoint se conserva.
      # Le pasamos /bin/sh como argumentos para preparar SQLite
      # antes de arrancar Apache.
      args = [
        "/bin/sh",
        "-c",
        <<-EOT
          set -eu
          cd /var/www/html

          touch /tmp/movistar.sqlite

            chown www-data:www-data /tmp/movistar.sqlite
            chmod 660 /tmp/movistar.sqlite

            php artisan migrate \
                --force \
                --no-interaction

            php artisan cobalt:update \
                 --no-interaction

            exec apache2-foreground
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
    }
  }

  depends_on = [
    google_secret_manager_secret_iam_member.movistar_runtime_access["laravel-app-key"]
  ]
}
