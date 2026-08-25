resource "google_storage_bucket" "movistar_build_logs" {
  name                        = "kn-co-cust-svc-movistar-prod-build-logs"
  project                     = "kn-co-cust-svc-movistar-prod"
  location                    = "US-CENTRAL1"
  storage_class               = "STANDARD"
  uniform_bucket_level_access = true
  public_access_prevention    = "enforced"

  force_destroy = false
}
