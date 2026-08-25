resource "google_artifact_registry_repository_iam_member" "movistar_cloud_build_writer" {
  project    = google_artifact_registry_repository.movistar_landing.project
  location   = google_artifact_registry_repository.movistar_landing.location
  repository = google_artifact_registry_repository.movistar_landing.repository_id

  role   = "roles/artifactregistry.writer"
  member = "serviceAccount:${google_service_account.movistar_cloud_build.email}"
}

resource "google_secret_manager_secret_iam_member" "movistar_cloud_build_bitbucket_access" {
  project   = google_secret_manager_secret.bitbucket_ssh_key.project
  secret_id = google_secret_manager_secret.bitbucket_ssh_key.secret_id

  role   = "roles/secretmanager.secretAccessor"
  member = "serviceAccount:${google_service_account.movistar_cloud_build.email}"
}

resource "google_project_iam_member" "movistar_cloud_build_logs_writer" {
  project = "kn-co-cust-svc-movistar-prod"
  role    = "roles/logging.logWriter"

  member = "serviceAccount:${google_service_account.movistar_cloud_build.email}"
}

resource "google_service_account_iam_member" "julian_movistar_cloud_build_user" {
  service_account_id = google_service_account.movistar_cloud_build.name

  role   = "roles/iam.serviceAccountUser"
  member = "user:julian.patino@konecta.com"
}
