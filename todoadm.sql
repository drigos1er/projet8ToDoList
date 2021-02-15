INSERT INTO `user` (`id`, `username`, `password`, `email`, `user_role`) VALUES
(8, 'todoadm', '$2y$13$g2D326TAtfVUj5uEwzHyROF5bn63IxOn5c67CkiDFJznV7D4s5DcK', 'todoadm@todo.ci', '1');

INSERT INTO `to_do_role_user` (`to_do_role_id`, `user_id`) VALUES
(1, 8)