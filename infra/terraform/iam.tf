resource "google_artifact_registry_repository_iam_member" "movistar_cloud_build_writer" {
  project    = google_artifact_registry_repository.movistar_landing.project
  location   = google_artifact_registry_repository.movistar_landing.location
  repository = google_artifact_registry_repository.movistar_landing.repository_id
  role       = "roles/artifactregistry.writer"
  member     = google_service_account.movistar_cloud_build.member
}

resource "google_secret_manager_secret_iam_member" "movistar_cloud_build_bitbucket_access" {
  project   = google_secret_manager_secret.bitbucket_ssh_key.project
  secret_id = google_secret_manager_secret.bitbucket_ssh_key.secret_id
  role      = "roles/secretmanager.secretAccessor"
  member    = google_service_account.movistar_cloud_build.member
}

resource "google_storage_bucket_iam_member" "movistar_cloud_build_logs" {
  bucket = google_storage_bucket.movistar_build_logs.name
  role   = "roles/storage.admin"
  member = google_service_account.movistar_cloud_build.member
}
