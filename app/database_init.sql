USE intelect;

DELETE FROM election;
ALTER TABLE election AUTO_INCREMENT = 1;
DELETE FROM election_election_group;
DELETE FROM vote;
ALTER TABLE vote AUTO_INCREMENT = 1;
DELETE FROM token;
DELETE FROM election_group;
ALTER TABLE election_group AUTO_INCREMENT = 1;
DELETE FROM user;
ALTER TABLE user AUTO_INCREMENT = 1;
DELETE FROM candidate;
ALTER TABLE candidate AUTO_INCREMENT = 1;


INSERT INTO user(username, password, type) VALUES ("admin", "$2y$10$3bFcjL2YZ8J1YcW.9QJ5Ze7KyMHERKtKymFXLVf7AJXnTVuvLrGj6", 1);
