SET CLIENT_MIN_MESSAGES TO WARNING;

DROP TABLE IF EXISTS locations CASCADE;
CREATE TABLE IF NOT EXISTS locations (
    id          SERIAL PRIMARY KEY,
    name        TEXT  NOT NULL,
    coordinates POINT NOT NULL,
    parent_id   INT   NOT NULL REFERENCES locations (id)
);

-- DROP TABLE IF EXISTS timezones CASCADE;
-- CREATE TABLE IF NOT EXISTS timezones (
--     id       SERIAL PRIMARY KEY,
--     name     TEXT NOT NULL UNIQUE,
--     "offset" INT  NOT NULL
-- );

DROP TABLE IF EXISTS users CASCADE;
CREATE TABLE IF NOT EXISTS users (
    id             SERIAL PRIMARY KEY,
    name           TEXT      NOT NULL,
    email          TEXT      NOT NULL UNIQUE,
    username       TEXT      NOT NULL UNIQUE,
    password       TEXT      NULL,
    remember_token TEXT      NULL,
    tagline        TEXT      NULL,
    bio            TEXT      NULL,
    birthday       DATE      NULL,
    gender         "char"    NULL, -- a custom type "gender" as ENUM is not used because "char" uses 1B, ENUM uses 4B
    avatar         TEXT      NULL,
    picture        TEXT      NULL,
    created_at     TIMESTAMP NOT NULL,
    updated_at     TIMESTAMP NOT NULL,
    location_id    INT       NULL REFERENCES locations (id)--,
--     timezone_id INT       NULL REFERENCES timezones (id)
);
COMMENT ON COLUMN users.gender IS 'M/F';

DROP TABLE IF EXISTS event_types CASCADE;
CREATE TABLE IF NOT EXISTS event_types (
    id   SERIAL PRIMARY KEY,
    name TEXT NOT NULL UNIQUE
);

DROP TABLE IF EXISTS events CASCADE;
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

DROP TABLE IF EXISTS issues CASCADE;
CREATE TABLE IF NOT EXISTS issues (
    id       SERIAL PRIMARY KEY,
    begin    TIMESTAMPTZ NOT NULL,
    "end"    TIMESTAMPTZ NULL     DEFAULT NULL,
    name     TEXT        NULL     DEFAULT NULL,
    suffix   BOOL        NOT NULL DEFAULT TRUE,
    event_id INT         NOT NULL REFERENCES events (id)
);
COMMENT ON COLUMN issues.suffix IS 'Should the name be included as a postfix or replaced?';

DROP TABLE IF EXISTS themes CASCADE;
CREATE TABLE IF NOT EXISTS themes (
    id          SERIAL PRIMARY KEY,
    name        TEXT NOT NULL UNIQUE,
    slug        TEXT NOT NULL UNIQUE,
    description TEXT NULL,
    link        TEXT NULL,
    parent_id   INT  NOT NULL REFERENCES themes (id)
);

DROP TABLE IF EXISTS material_types CASCADE;
CREATE TABLE IF NOT EXISTS material_types (
    id   SERIAL PRIMARY KEY,
    name TEXT NOT NULL UNIQUE
);

DROP TABLE IF EXISTS materials CASCADE;
CREATE TABLE IF NOT EXISTS materials (
    id               SERIAL PRIMARY KEY,
    title            TEXT NOT NULL,
    shortname        TEXT NULL,
    url              TEXT NULL,
    user_id          INT  NOT NULL REFERENCES users (id),
    material_type_id INT  NOT NULL REFERENCES material_types (id)
);

DROP TABLE IF EXISTS sessions CASCADE;
CREATE TABLE IF NOT EXISTS sessions (
    id          SERIAL PRIMARY KEY,
    title       TEXT        NOT NULL,
    description TEXT        NULL,
    time        TIMESTAMPTZ NOT NULL,
    event_id    INT REFERENCES events (id)
);

DROP TABLE IF EXISTS claim_requests CASCADE;
CREATE TABLE IF NOT EXISTS claim_requests (
    id       SERIAL PRIMARY KEY,
    phone    TEXT NOT NULL,
    email    TEXT NOT NULL,
    details  TEXT NULL,
    webpage  TEXT NULL,
    user_id  INT  NOT NULL REFERENCES users (id),
    event_id INT  NOT NULL REFERENCES events (id)
);

DROP TABLE IF EXISTS social_networks CASCADE;
CREATE TABLE IF NOT EXISTS social_networks (
    id   SERIAL PRIMARY KEY,
    name TEXT NOT NULL UNIQUE,
    url  TEXT NOT NULL UNIQUE,
    icon TEXT NOT NULL,
    position SMALLINT UNIQUE
);

DROP TABLE IF EXISTS social_links CASCADE;
CREATE TABLE IF NOT EXISTS social_links (
    id                SERIAL PRIMARY KEY,
    user_id           INT  NOT NULL REFERENCES users (id),
    social_network_id INT  NOT NULL REFERENCES social_networks (id),
    username          TEXT NOT NULL,
    CONSTRAINT unique_social_user UNIQUE (social_network_id, username)
);

DROP TABLE IF EXISTS notification_types CASCADE;
CREATE TABLE IF NOT EXISTS notification_types (
    id   SERIAL PRIMARY KEY,
    name TEXT NOT NULL UNIQUE,
    slug TEXT NOT NULL UNIQUE
);

DROP TABLE IF EXISTS notifications CASCADE;
CREATE TABLE IF NOT EXISTS notifications (
    id                   SERIAL PRIMARY KEY,
    date                 TIMESTAMPTZ NOT NULL,
    read                 BOOL        NOT NULL DEFAULT FALSE,
    notification_type_id INT         NOT NULL REFERENCES notification_types (id),
    event_id             INT         NOT NULL REFERENCES events (id),
    location_id          INT         NOT NULL REFERENCES locations (id),
    user_id              INT         NOT NULL REFERENCES users (id)
);

DROP TABLE IF EXISTS event_addresses CASCADE;
CREATE TABLE IF NOT EXISTS event_addresses (
    event_id    INT PRIMARY KEY REFERENCES events (id),
    line1       TEXT NOT NULL,
    line2       TEXT NULL,
    postal_code TEXT NULL
);

DROP TABLE IF EXISTS languages CASCADE;
CREATE TABLE IF NOT EXISTS languages (
    id   SERIAL PRIMARY KEY,
    name TEXT NOT NULL UNIQUE,
    abbr TEXT NOT NULL UNIQUE
);

DROP TABLE IF EXISTS event_language CASCADE;
CREATE TABLE IF NOT EXISTS event_language (
    event_id    INT NOT NULL REFERENCES events (id),
    language_id INT NOT NULL REFERENCES languages (id),
    PRIMARY KEY (event_id, language_id)
);

DROP TABLE IF EXISTS language_user CASCADE;
CREATE TABLE IF NOT EXISTS language_user (
    user_id     INT NOT NULL REFERENCES users (id),
    language_id INT NOT NULL REFERENCES languages (id),
    PRIMARY KEY (user_id, language_id)
);

DROP TABLE IF EXISTS following_user CASCADE;
CREATE TABLE IF NOT EXISTS following_user (
    follower_id INT NOT NULL REFERENCES users (id),
    user_id     INT NOT NULL REFERENCES users (id),
    PRIMARY KEY (follower_id, user_id)
);

DROP TABLE IF EXISTS participating_event CASCADE;
CREATE TABLE IF NOT EXISTS participating_event (
    user_id  INT NOT NULL REFERENCES users (id),
    event_id INT NOT NULL REFERENCES events (id),
    PRIMARY KEY (user_id, event_id)
);

DROP TABLE IF EXISTS following_event CASCADE;
CREATE TABLE IF NOT EXISTS following_event (
    user_id  INT NOT NULL REFERENCES users (id),
    event_id INT NOT NULL REFERENCES events (id),
    PRIMARY KEY (user_id, event_id)
);

DROP TABLE IF EXISTS event_staff CASCADE;
CREATE TABLE IF NOT EXISTS event_staff (
    event_id INT NOT NULL REFERENCES events (id),
    user_id  INT NOT NULL REFERENCES users (id),
    PRIMARY KEY (event_id, user_id)
);

DROP TABLE IF EXISTS event_material CASCADE;
CREATE TABLE IF NOT EXISTS event_material (
    event_id    INT NOT NULL REFERENCES events (id),
    material_id INT NOT NULL REFERENCES materials (id),
    PRIMARY KEY (event_id, material_id)
);

DROP TABLE IF EXISTS event_speaker CASCADE;
CREATE TABLE IF NOT EXISTS event_speaker (
    id        SERIAL PRIMARY KEY,
    event_id  INT  NOT NULL REFERENCES events (id),
    user_id   INT  NOT NULL REFERENCES users (id),
    important BOOL NOT NULL DEFAULT FALSE
);

DROP TABLE IF EXISTS event_theme CASCADE;
CREATE TABLE IF NOT EXISTS event_theme (
    event_id INT NOT NULL REFERENCES events (id),
    theme_id INT NOT NULL REFERENCES themes (id),
    PRIMARY KEY (event_id, theme_id)
);

DROP TABLE IF EXISTS following_theme CASCADE;
CREATE TABLE IF NOT EXISTS following_theme (
    theme_id    INT NOT NULL REFERENCES themes (id),
    user_id     INT NOT NULL REFERENCES users (id),
    location_id INT NOT NULL REFERENCES locations (id),
    PRIMARY KEY (theme_id, user_id, location_id)
);

DROP TABLE IF EXISTS notification_related_users CASCADE;
CREATE TABLE IF NOT EXISTS notification_related_users (
    notification_id INT NOT NULL REFERENCES notifications (id),
    user_id         INT NOT NULL REFERENCES users (id),
    PRIMARY KEY (notification_id, user_id)
);

DROP TABLE IF EXISTS event_wifis CASCADE;
CREATE TABLE IF NOT EXISTS event_wifis (
    event_id INT  NOT NULL PRIMARY KEY REFERENCES events (id),
    ssid     TEXT NOT NULL,
    password TEXT NULL
);

DROP TABLE IF EXISTS speaker_session CASCADE;
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
INSERT INTO social_networks (name, url, icon, position) VALUES ('Currículo Lattes', 'http://lattes.cnpq.br/','icon-site-lattes', 1);
INSERT INTO social_networks (name, url, icon, position) VALUES ('ResearchGate', 'http://www.researchgate.net/profile/', 'icon-site-researchgate', 2);
INSERT INTO social_networks (name, url, icon, position) VALUES ('LinkedIn', 'https://*.linkedin.com/in/', 'fa fa-linkedin-square', 3);

INSERT INTO social_networks (name, url, icon, position) VALUES ('Facebook', 'https://www.facebook.com/', 'fa fa-facebook-square', 4);
INSERT INTO social_networks (name, url, icon, position) VALUES ('Twitter', 'https://twitter.com/', 'fa fa-twitter-square', 5);
INSERT INTO social_networks (name, url, icon, position) VALUES ('Google+', 'http://www.google.com/+', 'fa fa-google-plus-square', 6);

INSERT INTO social_networks (name, url, icon, position) VALUES ('Slideshare', 'http://www.slideshare.net/', 'fa fa-slideshare', 7);
INSERT INTO social_networks (name, url, icon, position) VALUES ('Speaker Deck', 'https://speakerdeck.com/', 'icon-site-speaker-deck', 8);

INSERT INTO social_networks (name, url, icon, position) VALUES ('Flickr', 'https://www.flickr.com/photos/', 'fa fa-flickr', 9);
INSERT INTO social_networks (name, url, icon, position) VALUES ('Behance', 'https://www.behance.net/' , 'fa fa-behance-square', 10);
INSERT INTO social_networks (name, url, icon, position) VALUES ('GitHub', 'https://www.github.com/' , 'fa fa-github-square', 11);
INSERT INTO social_networks (name, url, icon, position) VALUES ('Bitbucket', 'https://www.bitbucket.org/' , 'fa fa-bitbucket-square', 12);

INSERT INTO social_networks (name, url, icon, position) VALUES ('Personal website', 'http', 'fa fa-globe', 99);
COMMIT;
