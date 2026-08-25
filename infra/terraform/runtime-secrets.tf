locals {
  movistar_runtime_secrets = toset([
    "laravel-app-key",
    "db-app-password",
    "anubis-user",
    "anubis-password",
    "cobalt-login",
    "cobalt-password",
    "tracking-webhook-password",
  ])
}

resource "google_secret_manager_secret" "movistar_runtime" {
  for_each = local.movistar_runtime_secrets

  project   = "kn-co-cust-svc-movistar-prod"
  secret_id = each.value

  replication {
    user_managed {
      replicas {
        location = "us-central1"
      }
    }
  }
}

resource "google_secret_manager_secret_iam_member" "movistar_runtime_access" {
  for_each = google_secret_manager_secret.movistar_runtime

  project   = each.value.project
  secret_id = each.value.secret_id

  role   = "roles/secretmanager.secretAccessor"
  member = google_service_account.movistar_cloud_build.member
}