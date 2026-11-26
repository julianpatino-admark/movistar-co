locals {
  movistar_runtime_secrets = toset([
    "laravel-app-key",
    "db-app-password",
    "db-runtime-password",
    "db-session-password",
    "anubis-user",
    "anubis-password",
    "cobalt-login",
    "cobalt-password",
    "gocontact-base-url",
    "gocontact-username",
    "gocontact-password",
    "gocontact-database-id",
    "gocontact-monitor-username",
    "gocontact-monitor-password",
    "tracking-webhook-password",
    "monitor-initial-password",
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
resource "google_secret_manager_secret_iam_member" "movistar_production_access" {
  for_each = toset([
    "laravel-app-key",
    "db-runtime-password",
    "db-session-password",
    "gocontact-base-url",
    "gocontact-username",
    "gocontact-password",
    "gocontact-database-id",
    "gocontact-monitor-username",
    "gocontact-monitor-password",
  ])

  project   = google_secret_manager_secret.movistar_runtime[each.key].project
  secret_id = google_secret_manager_secret.movistar_runtime[each.key].secret_id
  role      = "roles/secretmanager.secretAccessor"
  member    = data.google_service_account.movistar_production.member
}

resource "google_secret_manager_secret_iam_member" "monitor_initial_password_reader" {
  project   = google_secret_manager_secret.movistar_runtime["monitor-initial-password"].project
  secret_id = google_secret_manager_secret.movistar_runtime["monitor-initial-password"].secret_id
  role      = "roles/secretmanager.secretAccessor"
  member    = "user:julian.patino@konecta.com"
}
