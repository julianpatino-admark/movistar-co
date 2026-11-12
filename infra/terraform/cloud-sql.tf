data "google_sql_database_instance" "movistar" {
  project = "kn-co-cust-svc-movistar-prod"
  name    = "landing-movistar"
}

ephemeral "google_secret_manager_secret_version" "database_password" {
  project = "kn-co-cust-svc-movistar-prod"
  secret  = google_secret_manager_secret.movistar_runtime["db-app-password"].secret_id
  version = "1"
}

resource "google_sql_database" "movistar" {
  project         = "kn-co-cust-svc-movistar-prod"
  instance        = data.google_sql_database_instance.movistar.name
  name            = "movistar"
  charset         = "utf8mb4"
  collation       = "utf8mb4_unicode_ci"
  deletion_policy = "ABANDON"
}

resource "google_sql_user" "movistar" {
  project             = "kn-co-cust-svc-movistar-prod"
  instance            = data.google_sql_database_instance.movistar.name
  name                = "movistar_app"
  host                = "%"
  password_wo         = ephemeral.google_secret_manager_secret_version.database_password.secret_data
  password_wo_version = 1
}

resource "google_sql_database" "sessions" {
  project         = data.google_sql_database_instance.movistar.project
  instance        = data.google_sql_database_instance.movistar.name
  name            = "movistar_sessions"
  charset         = "utf8mb4"
  collation       = "utf8mb4_unicode_ci"
  deletion_policy = "ABANDON"
}

ephemeral "google_secret_manager_secret_version" "runtime_database_passwords" {
  for_each = local.movistar_database_runtime_accounts
  project  = data.google_sql_database_instance.movistar.project
  secret   = google_secret_manager_secret.movistar_runtime[each.value.secret].secret_id
  version  = "2"
}

locals {
  movistar_database_runtime_accounts = {
    application = { name = "movistar_runtime", role = "movistar_runtime_role", secret = "db-runtime-password" }
    sessions    = { name = "movistar_session", role = "movistar_session_role", secret = "db-session-password" }
  }
}

resource "google_sql_user" "runtime" {
  for_each            = local.movistar_database_runtime_accounts
  project             = data.google_sql_database_instance.movistar.project
  instance            = data.google_sql_database_instance.movistar.name
  name                = each.value.name
  host                = "%"
  type                = "BUILT_IN"
  database_roles      = [each.value.role]
  password_wo         = ephemeral.google_secret_manager_secret_version.runtime_database_passwords[each.key].secret_data
  password_wo_version = 2
}
