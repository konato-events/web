SET CLIENT_MIN_MESSAGES TO WARNING;

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
    id       SERIAL PRIMARY KEY,
    name     TEXT      NOT NULL,
    email    TEXT      NOT NULL UNIQUE,
    password TEXT      NULL DEFAULT NULL,
    username TEXT      NOT NULL UNIQUE,
    tagline  TEXT      NULL DEFAULT NULL,
    bio      TEXT      NULL DEFAULT NULL,
    birthday TIMESTAMP NULL DEFAULT NULL
);

DROP TABLE IF EXISTS locations;
CREATE TABLE IF NOT EXISTS locations (
    id          SERIAL PRIMARY KEY,
    name        TEXT  NOT NULL,
    coordinates POINT NOT NULL,
    parent_id   INT   NOT NULL REFERENCES locations (id)
);

DROP TABLE IF EXISTS event_types;
CREATE TABLE IF NOT EXISTS event_types (
    id   SERIAL PRIMARY KEY,
    name TEXT NOT NULL UNIQUE
);

DROP TABLE IF EXISTS events;
CREATE TABLE IF NOT EXISTS events (
    id                     SERIAL PRIMARY KEY,
    title                  TEXT     NOT NULL UNIQUE,
    slug                   TEXT     NOT NULL UNIQUE,
    location_id            INT      NOT NULL REFERENCES locations (id),
    website                TEXT     NULL,
    twitter                TEXT     NULL,
    hashtag                TEXT     NULL UNIQUE,
    disclosed_participants INT      NULL,
    free                   BOOL     NOT NULL DEFAULT FALSE,
    closed                 BOOL     NOT NULL DEFAULT FALSE,
    published              BOOL     NOT NULL DEFAULT FALSE,
    status                 SMALLINT NOT NULL DEFAULT 0,
    event_type_id          INT      NOT NULL REFERENCES event_types (id)
);
COMMENT ON COLUMN events.status IS '0 => future; 1 => happening; 2 => past';

DROP TABLE IF EXISTS issues;
CREATE TABLE IF NOT EXISTS issues (
    id       SERIAL PRIMARY KEY,
    begin    TIMESTAMPTZ NOT NULL,
    "end"    TIMESTAMPTZ NULL     DEFAULT NULL,
    name     TEXT        NULL     DEFAULT NULL,
    suffix   BOOL        NOT NULL DEFAULT TRUE,
    event_id INT         NOT NULL REFERENCES events (id)
);
COMMENT ON COLUMN issues.suffix IS 'Should the name be included as a postfix or replaced?';

DROP TABLE IF EXISTS themes;
CREATE TABLE IF NOT EXISTS themes (
    id          SERIAL PRIMARY KEY,
    name        TEXT NOT NULL UNIQUE,
    slug        TEXT NOT NULL UNIQUE,
    description TEXT NULL DEFAULT NULL,
    link        TEXT NULL DEFAULT NULL,
    parent_id   INT  NOT NULL REFERENCES themes (id)
);

DROP TABLE IF EXISTS material_types;
CREATE TABLE IF NOT EXISTS material_types (
    id   SERIAL PRIMARY KEY,
    name TEXT NOT NULL UNIQUE
);

DROP TABLE IF EXISTS materials;
CREATE TABLE IF NOT EXISTS materials (
    id               SERIAL PRIMARY KEY,
    title            TEXT NOT NULL,
    shortname        TEXT NULL DEFAULT NULL,
    url              TEXT NULL DEFAULT NULL,
    user_id          INT  NOT NULL REFERENCES users (id),
    material_type_id INT  NOT NULL REFERENCES material_types (id)
);

DROP TABLE IF EXISTS sessions;
CREATE TABLE IF NOT EXISTS sessions (
    id          SERIAL PRIMARY KEY,
    title       TEXT        NOT NULL,
    description TEXT        NULL DEFAULT NULL,
    time        TIMESTAMPTZ NOT NULL,
    event_id    INT REFERENCES events (id)
);

DROP TABLE IF EXISTS claim_requests;
CREATE TABLE IF NOT EXISTS claim_requests (
    id       SERIAL PRIMARY KEY,
    phone    TEXT NOT NULL,
    email    TEXT NOT NULL,
    details  TEXT NULL DEFAULT NULL,
    webpage  TEXT NULL DEFAULT NULL,
    user_id  INT  NOT NULL REFERENCES users (id),
    event_id INT  NOT NULL REFERENCES events (id)
);

DROP TABLE IF EXISTS social_networks;
CREATE TABLE IF NOT EXISTS social_networks (
    id   SERIAL PRIMARY KEY,
    name TEXT NOT NULL UNIQUE,
    url  TEXT NOT NULL UNIQUE
);

DROP TABLE IF EXISTS social_links;
CREATE TABLE IF NOT EXISTS social_links (
    id                SERIAL PRIMARY KEY,
    user_id           INT  NOT NULL REFERENCES users (id),
    social_network_id INT  NOT NULL REFERENCES social_networks (id),
    username          TEXT NOT NULL,
    CONSTRAINT unique_social_user UNIQUE (social_network_id, username)
);

DROP TABLE IF EXISTS notification_types;
CREATE TABLE IF NOT EXISTS notification_types (
    id   SERIAL PRIMARY KEY,
    name TEXT NOT NULL UNIQUE,
    slug TEXT NOT NULL UNIQUE
);

DROP TABLE IF EXISTS notifications;
CREATE TABLE IF NOT EXISTS notifications (
    id                   SERIAL PRIMARY KEY,
    date                 TIMESTAMPTZ NOT NULL,
    read                 BOOL        NOT NULL DEFAULT FALSE,
    notification_type_id INT         NOT NULL REFERENCES notification_types (id),
    event_id             INT         NOT NULL REFERENCES events (id),
    location_id          INT         NOT NULL REFERENCES locations (id),
    user_id              INT         NOT NULL REFERENCES users (id)
);

DROP TABLE IF EXISTS event_addresses;
CREATE TABLE IF NOT EXISTS event_addresses (
    event_id    INT PRIMARY KEY REFERENCES events (id),
    line1       TEXT NOT NULL,
    line2       TEXT NULL,
    postal_code TEXT NULL
);

DROP TABLE IF EXISTS languages;
CREATE TABLE IF NOT EXISTS languages (
    id   SERIAL PRIMARY KEY,
    name TEXT NOT NULL UNIQUE,
    abbr TEXT NOT NULL UNIQUE
);

DROP TABLE IF EXISTS event_language;
CREATE TABLE IF NOT EXISTS event_language (
    event_id    INT NOT NULL REFERENCES events (id),
    language_id INT NOT NULL REFERENCES languages (id),
    PRIMARY KEY (event_id, language_id)
);

DROP TABLE IF EXISTS following_user;
CREATE TABLE IF NOT EXISTS following_user (
    follower_id INT NOT NULL REFERENCES users (id),
    user_id     INT NOT NULL REFERENCES users (id),
    PRIMARY KEY (follower_id, user_id)
);

DROP TABLE IF EXISTS participating_event;
CREATE TABLE IF NOT EXISTS participating_event (
    user_id  INT NOT NULL REFERENCES users (id),
    event_id INT NOT NULL REFERENCES events (id),
    PRIMARY KEY (user_id, event_id)
);

DROP TABLE IF EXISTS following_event;
CREATE TABLE IF NOT EXISTS following_event (
    user_id  INT NOT NULL REFERENCES users (id),
    event_id INT NOT NULL REFERENCES events (id),
    PRIMARY KEY (user_id, event_id)
);

DROP TABLE IF EXISTS event_staff;
CREATE TABLE IF NOT EXISTS event_staff (
    event_id INT NOT NULL REFERENCES events (id),
    user_id  INT NOT NULL REFERENCES users (id),
    PRIMARY KEY (event_id, user_id)
);

DROP TABLE IF EXISTS event_material;
CREATE TABLE IF NOT EXISTS event_material (
    event_id    INT NOT NULL REFERENCES events (id),
    material_id INT NOT NULL REFERENCES materials (id),
    PRIMARY KEY (event_id, material_id)
);

DROP TABLE IF EXISTS event_speaker;
CREATE TABLE IF NOT EXISTS event_speaker (
    id        SERIAL PRIMARY KEY,
    event_id  INT  NOT NULL REFERENCES events (id),
    user_id   INT  NOT NULL REFERENCES users (id),
    important BOOL NOT NULL DEFAULT FALSE
);

DROP TABLE IF EXISTS event_theme;
CREATE TABLE IF NOT EXISTS event_theme (
    event_id INT NOT NULL REFERENCES events (id),
    theme_id INT NOT NULL REFERENCES themes (id),
    PRIMARY KEY (event_id, theme_id)
);

DROP TABLE IF EXISTS following_theme;
CREATE TABLE IF NOT EXISTS following_theme (
    theme_id    INT NOT NULL REFERENCES themes (id),
    user_id     INT NOT NULL REFERENCES users (id),
    location_id INT NOT NULL REFERENCES locations (id),
    PRIMARY KEY (theme_id, user_id, location_id)
);

DROP TABLE IF EXISTS notification_related_users;
CREATE TABLE IF NOT EXISTS notification_related_users (
    notification_id INT NOT NULL REFERENCES notifications (id),
    user_id         INT NOT NULL REFERENCES users (id),
    PRIMARY KEY (notification_id, user_id)
);

DROP TABLE IF EXISTS event_wifis;
CREATE TABLE IF NOT EXISTS event_wifis (
    event_id INT  NOT NULL PRIMARY KEY REFERENCES events (id),
    ssid     TEXT NOT NULL,
    password TEXT NULL
);

DROP TABLE IF EXISTS speaker_session;
CREATE TABLE IF NOT EXISTS speaker_session (
    event_speaker_id INT NOT NULL REFERENCES event_speaker (id),
    session_id       INT NOT NULL REFERENCES sessions (id),
    PRIMARY KEY (event_speaker_id, session_id)
);

-- -----------------------------------------------------
-- Data for table event_types
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO event_types (name) VALUES ('meeting');
INSERT INTO event_types (name) VALUES ('talk');
INSERT INTO event_types (name) VALUES ('talks');
INSERT INTO event_types (name) VALUES ('course');
INSERT INTO event_types (name) VALUES ('workshop');
INSERT INTO event_types (name) VALUES ('conference');
INSERT INTO event_types (name) VALUES ('symposium');
INSERT INTO event_types (name) VALUES ('congress');
INSERT INTO event_types (name) VALUES ('university meeting');
INSERT INTO event_types (name) VALUES ('entertainment');
COMMIT;

-- -----------------------------------------------------
-- Data for table material_types
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO material_types (name) VALUES ('article');
INSERT INTO material_types (name) VALUES ('abstract');
INSERT INTO material_types (name) VALUES ('presentation');
COMMIT;

-- -----------------------------------------------------
-- Data for table social_networks
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO social_networks (name, url) VALUES ('LinkedIn', 'https://*.linkedin.com/in/');
INSERT INTO social_networks (name, url) VALUES ('Currículo Lattes', 'http://lattes.cnpq.br/');
INSERT INTO social_networks (name, url) VALUES ('Slideshare', 'http://www.slideshare.net/');
INSERT INTO social_networks (name, url) VALUES ('Twitter', 'https://twitter.com/');
INSERT INTO social_networks (name, url) VALUES ('Google+', 'http://www.google.com/+');
INSERT INTO social_networks (name, url) VALUES ('Facebook', 'https://www.facebook.com/');
INSERT INTO social_networks (name, url) VALUES ('ResearchGate', 'http://www.researchgate.net/profile/');
INSERT INTO social_networks (name, url) VALUES ('Personal website', 'http');
COMMIT;
