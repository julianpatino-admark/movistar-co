terraform {
  backend "gcs" {
    bucket = "kn-co-cust-svc-movistar-prod-tfstate"
    prefix = "movistar/prod"
  }
}
