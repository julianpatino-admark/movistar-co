provider "google" {
  project = "kn-co-cust-svc-movistar-prod"
  region  = "us-central1"
}

resource "google_artifact_registry_repository" "movistar_landing" {
  project       = "kn-co-cust-svc-movistar-prod"
  location      = "us-central1"
  repository_id = "movistar-landing"
  description   = "Movistar landing Docker images"
  format        = "DOCKER"
}

resource "google_secret_manager_secret" "bitbucket_ssh_key" {
  project   = "kn-co-cust-svc-movistar-prod"
  secret_id = "bitbucket-ssh-key"

  replication {
    user_managed {
      replicas {
        location = "us-central1"
      }
    }
  }
}
