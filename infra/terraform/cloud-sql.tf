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
