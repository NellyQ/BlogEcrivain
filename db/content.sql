insert into billets values
(1, 'Premier billet', 'Voici le tout premier billet.', '2017-06-01');
insert into billets values
(2, 'Deuxième billet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut hendrerit mauris ac porttitor accumsan. Nunc vitae pulvinar odio, auctor interdum dolor','2017-06-02');


/* raw password is 'john' */
insert into users values
(1, 'JohnDoe', '$2y$13$F9v8pl5u5WMrCorP9MLyJeyIsOLj.0/xqKd/hqa5440kyeB7FQ8te', 'YcM=A$nsYzkyeDVjEUa7W9K', 'ROLE_USER');
/* raw password is 'jane' */
insert into users values
(2, 'JaneDoe', '$2y$13$qOvvtnceX.TjmiFn4c4vFe.hYlIVXHSPHfInEG21D99QZ6/LM70xa', 'dhMTBkzwDKxnD;4KNs,4ENy', 'ROLE_USER');

insert into comments values
(1, 'Great! Keep up the good work.', 1, 1);
insert into comments values
(2, "Thank you, I'll try my best.", 1, 2);
