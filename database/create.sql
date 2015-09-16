-- -----------------------------------------------------
-- Table participant
-- -----------------------------------------------------
CREATE TABLE participant (
  id       SERIAL    PRIMARY KEY,
  name     TEXT      NOT NULL,
  email    TEXT      NOT NULL,
  password TEXT      NOT NULL,
  username TEXT      NOT NULL,
  tagline  TEXT      NULL,
  bio      TEXT      NULL,
  birthday TIMESTAMP NULL
);


-- -----------------------------------------------------
-- Table speaker
-- -----------------------------------------------------
CREATE TABLE speaker (
  participant_id INT  PRIMARY KEY REFERENCES participant,
  important      BOOL NOT NULL DEFAULT TRUE
);
COMMENT ON COLUMN speaker.important IS 'To be displayed in the events home page?';

-- -----------------------------------------------------
-- Table location
-- -----------------------------------------------------
CREATE TABLE location (
  id          SERIAL PRIMARY KEY,
  name        TEXT  NOT NULL,
  coordinates POINT NOT NULL,
  parent_id   INT   NULL REFERENCES location
);

-- -----------------------------------------------------
-- Table eventType
-- -----------------------------------------------------
CREATE TABLE eventType (
  id   SERIAL PRIMARY KEY,
  name TEXT NOT NULL UNIQUE
);


-- -----------------------------------------------------
-- Table event
-- -----------------------------------------------------
CREATE TABLE event (
  id                    SERIAL   PRIMARY KEY,
  title                 TEXT     NOT NULL UNIQUE,
  slug                  TEXT     NOT NULL UNIQUE,
  location_id           INT      NOT NULL REFERENCES location,
  website               TEXT     NULL,
  twitter               TEXT     NULL,
  hashtag               TEXT     NULL UNIQUE,
  disclosedParticipants INT      NULL,
  free                  BOOL     NOT NULL DEFAULT FALSE,
  closed                BOOL     NOT NULL DEFAULT FALSE,
  published             BOOL     NOT NULL DEFAULT FALSE,
  status                SMALLINT NOT NULL DEFAULT 0,
  eventType_id          INT      NOT NULL REFERENCES eventType
);
COMMENT ON COLUMN event.status IS '0 => future\n1 => happening\n2 => past';


-- -----------------------------------------------------
-- Table issue
-- -----------------------------------------------------
CREATE TABLE issue (
  id     SERIAL      PRIMARY KEY,
  begin  TIMESTAMPTZ NOT NULL,
  "end"  TIMESTAMPTZ NULL,
  name   TEXT        NULL,
  suffix BOOL        NOT NULL DEFAULT TRUE,
  event_id INT       NOT NULL REFERENCES event
);
COMMENT ON COLUMN issue.suffix IS 'Should the name be included as a postfix or replaced?';

-- -----------------------------------------------------
-- Table theme
-- -----------------------------------------------------
CREATE TABLE theme (
  id          SERIAL PRIMARY KEY,
  name        TEXT   NOT NULL UNIQUE,
  slug        TEXT   NOT NULL UNIQUE,
  description TEXT   NULL,
  link        TEXT   NULL,
  parent_id   INT    NOT NULL REFERENCES theme
);


-- -----------------------------------------------------
-- Table materialType
-- -----------------------------------------------------
CREATE TABLE materialType (
  id   SERIAL PRIMARY KEY,
  name TEXT   NOT NULL UNIQUE
);


-- -----------------------------------------------------
-- Table material
-- -----------------------------------------------------
CREATE TABLE material (
  id              SERIAL PRIMARY KEY,
  title           TEXT   NOT NULL,
  shortname       TEXT   NULL,
  url             TEXT   NULL,
  participant_id  INT    NOT NULL REFERENCES participant,
  materialType_id INT    NOT NULL REFERENCES materialType
);


-- -----------------------------------------------------
-- Table session
-- -----------------------------------------------------
CREATE TABLE session (
  id          SERIAL      PRIMARY KEY,
  title       TEXT        NOT NULL,
  description TEXT        NULL,
  time        TIMESTAMPTZ NOT NULL
);


-- -----------------------------------------------------
-- Table ClaimRequest
-- -----------------------------------------------------
CREATE TABLE ClaimRequest (
  id             SERIAL  PRIMARY KEY,
  phone          TEXT    NOT NULL,
  email          TEXT    NOT NULL,
  details        TEXT    NULL,
  webpage        TEXT    NULL,
  participant_id INT NOT NULL REFERENCES participant,
  event_id       INT NOT NULL REFERENCES event
);


-- -----------------------------------------------------
-- Table socialNetwork
-- -----------------------------------------------------
CREATE TABLE socialNetwork (
  id      SERIAL PRIMARY KEY,
  name    TEXT NOT NULL UNIQUE,
  userURL TEXT NOT NULL UNIQUE
);


-- -----------------------------------------------------
-- Table socialLink
-- -----------------------------------------------------
CREATE TABLE socialLink (
  id               SERIAL PRIMARY KEY,
  participant_id   INT  NOT NULL REFERENCES participant,
  socialNetwork_id INT  NOT NULL REFERENCES socialNetwork,
  username         TEXT NOT NULL,
  UNIQUE (socialNetwork_id, username)
);


-- -----------------------------------------------------
-- Table notificationType
-- -----------------------------------------------------
CREATE TABLE notificationType (
  id   SERIAL PRIMARY KEY,
  name TEXT   NOT NULL UNIQUE,
  slug TEXT   NOT NULL UNIQUE
);


-- -----------------------------------------------------
-- Table notification
-- -----------------------------------------------------
CREATE TABLE notification (
  id                  SERIAL      PRIMARY KEY,
  date                TIMESTAMPTZ NOT NULL,
  read                BOOL        NOT NULL DEFAULT FALSE,
  notificationType_id INT         NOT NULL REFERENCES notificationType,
  event_id            INT         NOT NULL REFERENCES event,
  location_id         INT         NOT NULL REFERENCES location,
  participant_id      INT         NOT NULL REFERENCES participant
);


-- -----------------------------------------------------
-- Table eventAddress
-- -----------------------------------------------------
CREATE TABLE eventAddress (
  event_id   INT  NOT NULL REFERENCES event,
  line1      TEXT NOT NULL,
  line2      TEXT NULL,
  postalCode TEXT NULL
);


-- -----------------------------------------------------
-- Table language
-- -----------------------------------------------------
CREATE TABLE language (
  id   SERIAL PRIMARY KEY,
  name TEXT NOT NULL UNIQUE,
  abbr TEXT NOT NULL UNIQUE
);


-- -----------------------------------------------------
-- Table event_language
-- -----------------------------------------------------
CREATE TABLE event_language (
  event_id    INT NOT NULL REFERENCES event,
  language_id INT NOT NULL REFERENCES language,
  PRIMARY KEY (event_id, language_id)
);


-- -----------------------------------------------------
-- Table speaker_session
-- -----------------------------------------------------
CREATE TABLE speaker_session (
  speaker_id INT NOT NULL REFERENCES speaker,
  session_id INT NOT NULL REFERENCES session,
  PRIMARY KEY (speaker_id, session_id)
);


-- -----------------------------------------------------
-- Table followingParticipant
-- -----------------------------------------------------
CREATE TABLE followingParticipant (
  follower_id    INT NOT NULL REFERENCES participant,
  participant_id INT NOT NULL REFERENCES participant,
  PRIMARY KEY (follower_id, participant_id)
);


-- -----------------------------------------------------
-- Table participantingEvent
-- -----------------------------------------------------
CREATE TABLE participantingEvent (
  participant_id INT NOT NULL REFERENCES participant,
  event_id       INT NOT NULL REFERENCES event,
  PRIMARY KEY (participant_id, event_id)
);


-- -----------------------------------------------------
-- Table followingEvent
-- -----------------------------------------------------
CREATE TABLE followingEvent (
  participant_id INT NOT NULL REFERENCES participant,
  event_id       INT NOT NULL REFERENCES event,
  PRIMARY KEY (participant_id, event_id)
);


-- -----------------------------------------------------
-- Table event_session
-- -----------------------------------------------------
CREATE TABLE event_session (
  event_id   INT NOT NULL REFERENCES event,
  session_id INT NOT NULL REFERENCES session,
  PRIMARY KEY (event_id, session_id)
);


-- -----------------------------------------------------
-- Table eventStaff
-- -----------------------------------------------------
CREATE TABLE eventStaff (
  event_id       INT NOT NULL REFERENCES event,
  participant_id INT NOT NULL REFERENCES participant,
  PRIMARY KEY (event_id, participant_id)
);


-- -----------------------------------------------------
-- Table event_material
-- -----------------------------------------------------
CREATE TABLE event_material (
  event_id    INT NOT NULL REFERENCES event,
  material_id INT NOT NULL REFERENCES material,
  PRIMARY KEY (event_id, material_id)
);


-- -----------------------------------------------------
-- Table event_speaker
-- -----------------------------------------------------
CREATE TABLE event_speaker (
  event_id   INT NOT NULL REFERENCES event,
  speaker_id INT NOT NULL REFERENCES speaker,
  PRIMARY KEY (event_id, speaker_id)
);


-- -----------------------------------------------------
-- Table event_theme
-- -----------------------------------------------------
CREATE TABLE event_theme (
  event_id INT NOT NULL REFERENCES event,
  theme_id INT NOT NULL REFERENCES theme,
  PRIMARY KEY (event_id, theme_id)
);


-- -----------------------------------------------------
-- Table followingTheme
-- -----------------------------------------------------
CREATE TABLE followingTheme (
  theme_id       INT NOT NULL REFERENCES theme,
  participant_id INT NOT NULL REFERENCES participant,
  location_id    INT NOT NULL REFERENCES location,
  PRIMARY KEY (theme_id, participant_id, location_id)
);


-- -----------------------------------------------------
-- Table relatedParticipants
-- -----------------------------------------------------
CREATE TABLE relatedParticipants (
  notification_id INT NOT NULL REFERENCES notification,
  participant_id  INT NOT NULL REFERENCES participant,
  PRIMARY KEY (notification_id, participant_id)
);

-- -----------------------------------------------------
-- Data for table eventType
-- -----------------------------------------------------
START TRANSACTION;
  INSERT INTO eventType (name) VALUES ('meeting');
  INSERT INTO eventType (name) VALUES ('talk');
  INSERT INTO eventType (name) VALUES ('talks');
  INSERT INTO eventType (name) VALUES ('course');
  INSERT INTO eventType (name) VALUES ('workshop');
  INSERT INTO eventType (name) VALUES ('conference');
  INSERT INTO eventType (name) VALUES ('symposium');
  INSERT INTO eventType (name) VALUES ('congress');
  INSERT INTO eventType (name) VALUES ('university meeting');
  INSERT INTO eventType (name) VALUES ('entertainment');
COMMIT;


-- -----------------------------------------------------
-- Data for table materialType
-- -----------------------------------------------------
START TRANSACTION;
  INSERT INTO materialType (name) VALUES ('article');
  INSERT INTO materialType (name) VALUES ('abstract');
  INSERT INTO materialType (name) VALUES ('presentation');
COMMIT;


-- -----------------------------------------------------
-- Data for table socialNetwork
-- -----------------------------------------------------
START TRANSACTION;
  INSERT INTO socialNetwork (name, userURL) VALUES ('LinkedIn', 'https://*.linkedin.com/in/');
  INSERT INTO socialNetwork (name, userURL) VALUES ('Currículo Lattes', 'http://lattes.cnpq.br/');
  INSERT INTO socialNetwork (name, userURL) VALUES ('Slideshare', 'http://www.slideshare.net/');
  INSERT INTO socialNetwork (name, userURL) VALUES ('Twitter', 'https://twitter.com/');
  INSERT INTO socialNetwork (name, userURL) VALUES ('Google+', 'http://www.google.com/+');
  INSERT INTO socialNetwork (name, userURL) VALUES ('Facebook', 'https://www.facebook.com/');
  INSERT INTO socialNetwork (name, userURL) VALUES ('ResearchGate', 'http://www.researchgate.net/profile/');
  INSERT INTO socialNetwork (name, userURL) VALUES ('Personal website', 'http');
COMMIT;

