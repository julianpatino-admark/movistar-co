resource "google_service_account" "movistar_cloud_build" {
  project      = "kn-co-cust-svc-movistar-prod"
  account_id   = "movistar-cloud-build"
  display_name = "Movistar Cloud Build"
  description  = "Build and publish Movistar landing container images"
}
