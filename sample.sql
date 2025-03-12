USE messup;

INSERT INTO users (picture, username, password) VALUES (NULL, 'user1', 'password1'),
                                                      (NULL, 'user2', 'password2'),
                                                      (NULL, 'user3', 'password3');

INSERT INTO message (content, time, idUser, idSalle) VALUES ('1', '2019-01-01 00:00:00', 1, 3),
                                                            ('2','2019-01-01 01:00:00',2,3),
                                                            ('3','2019-01-01 02:00:00',3,3),
                                                            ('AAA','2019-01-01 01:00:00',2,3),
                                                            ('BBB','2019-01-01 01:00:00',2,3),
                                                            ('CCC','2019-01-01 01:00:00',2,3),
                                                            ('DDDD','2019-01-01 01:00:00',2,3),
                                                            ('EEEEE','2019-01-01 01:00:00',2,3),
                                                            ('FF','2019-01-01 01:00:00',2,3),
                                                            ('GG','2019-01-01 01:00:00',2,3),
                                                            ('TY','2019-01-01 01:00:00',2,3);

