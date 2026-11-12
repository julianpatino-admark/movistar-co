-- Run as a MySQL administrator after Terraform creates google_sql_database.sessions
-- and before applying google_sql_user.runtime or promoting the Cloud Run revision.
CREATE TABLE IF NOT EXISTS movistar_sessions.sessions (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
) ENGINE=InnoDB;

CREATE ROLE IF NOT EXISTS 'movistar_runtime_role', 'movistar_session_role';

GRANT SELECT, INSERT, UPDATE, DELETE ON movistar.* TO 'movistar_runtime_role';
GRANT SELECT, INSERT, UPDATE, DELETE ON movistar_sessions.sessions TO 'movistar_session_role';
