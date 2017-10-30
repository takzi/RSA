-- ROLE =======================================================================
INSERT INTO `role` VALUES 
(0,'Administrator'),
(0,'Congregation Scheduler'),
(0,'Bus Driver Scheduler'),
(0,'Congregation Leader'),
(0,'Bus Driver');

-- USER =======================================================================
INSERT INTO `user` VALUES
(0, 'Kristen', 'Merritt', 1, 'km2029@rit.edu', '$2y$10$da2lsTqiCqIQ1CJZoeM3kuMRT.9N4i40XBmmGF0swIBWkdk4WnHH2'),
(0, 'Amanda', 'Bynes', 3, 'takzitest@gmail.com', 'password'),
(0, 'Donald', 'Trump', 4, 'takzitest2@gmail.com', 'password'),
(0, 'Barack', 'Obama', 4, 'takzitest3@gmail.com', 'password'),
(0, 'Bernie', 'Sanders', 3, 'takzitest4@gmail.com', 'password'),
(0, 'Hillary', 'Clinton', 3, 'takzitest5@gmail.com', 'password'),
(0, 'George', 'Bush', 3, 'takzitest6@gmail.com', 'password'),
(0, 'Bill', 'Clinton', 3, 'takzitest7@gmail.com', 'password'),
(0, 'John', 'Snow', 4, 'takzitest8@gmail.com', 'password'),
(0, 'Danaerys', 'Targaryen', 4, 'takzitest9@gmail.com', 'password'),
(0, 'Cersei', 'Lannister', 3, 'takzitest10@gmail.com', 'password'),
(0, 'Sansa', 'Stark', 4, 'takzitest11@gmail.com', 'password'),
(0, 'Tyrion', 'Lannister', 3, 'takzitest12@gmail.com', 'password'),
(0, 'Taylor', 'Swift', 3, 'takzitest13@gmail.com', 'password'),
(0, 'Jennifer', 'Lawrence', 3, 'takzitest14@gmail.com', 'password'),
(0, 'Frank', 'Underwood', 3, 'takzitest15@gmail.com', 'password'),
(0, 'Kanye', 'West', 3, 'takzitest16@gmail.com', 'password'),
(0, 'Michael', 'Scott', 3, 'takzitest17@gmail.com', 'password'),
(0, 'Jim', 'Halpert', 4, 'takzitest18@gmail.com', 'password'),
(0, 'Dwight', 'Schrute', 3, 'takzitest19@gmail.com', 'password'),
(0, 'Kristen', 'Test', 1, 'test@test.com', '$2y$10$mC5chca3RBB3REbtSu8PKeDoLo66MvIPT4BjXBylUg/pjLfEb2BCy'),
(0, 'Tiandre', 'Turner', 1, 'tjt9156@rit.edu', '$2y$10$nE6lGMKL7aiUfI/2kRXnfO5yc9siT3NJZfWfXPxzrcS3CVBDmmchC');

-- BUS DRIVER =================================================================
INSERT INTO `bus_driver` VALUES
(0, 4, '(585) 456-3789'),
(0, 5, '(585) 789-4723'),
(0, 10, '(585) 589-4215'),
(0, 11, '(585) 893-6588'),
(0, 13, '(585) 231-8976'),
(0, 20, '(585) 777-4565');

-- CONGREGATION ===============================================================
INSERT INTO `congregation` VALUES
(0, 3, 'DUPC'),
(0, 6, 'First Presbyterian Pittsford'),
(0, 7, "St. Paul's Episcopal"),
(0, 8, 'Two Saints'),
(0, 9, 'First Universalist'),
(0, 12, 'Incarnate World'),
(0, 14, 'Assumption'),
(0, 15, 'Asbury Methodist'),
(0, 16, 'Mary Magdalene'),
(0, 17, 'First Unitarian'),
(0, 18, 'Temple Sinai'),
(0, 19, 'Day Center'),
(0, 21, 'Third Presbyterian');

-- SUPPORTING CONGREGATION ====================================================
INSERT INTO `supporting_congregation` VALUES
(0, 'Religious Society of Friends'),
(0, "St. Paul's Lutheran"),
(0, 'Christ Church Pittsford'),
(0, 'Incarnation'),
(0, 'Good Shepherd'),
(0, 'Webster UCC'),
(0, 'Zen Center'),
(0, 'Christ Episcopal'),
(0, 'Elmgrove UCC'),
(0, 'Aldersgate'),
(0, 'Church of Love'),
(0, "St. Mary's"),
(0, 'Messiah Lutheran'),
(0, 'Bethany Presbyterian'),
(0, "St. Luke's"),
(0, 'Baber AME'),
(0, 'Baptist Temple'),
(0, 'Greece Baptist'),
(0, 'Transfiguration'),
(0, 'St. Louis'),
(0, 'St. Catherine'),
(0, 'United Church of Pittsford'),
(0, 'Temple Beth EL'),
(0, "St. Joseph's Penfield"),
(0, 'ALL CONGREGATIONS'),
(0, 'New Life Presbyterian');

-- CONGREGATION SUPPORTING  ====================================================
INSERT INTO `congregation_supporting` VALUES
(1,1),
(2,2),
(2,3),
(3,4),
(3,5),
(3,6),
(3,7),
(4,8),
(4,9),
(5,10),
(5,11),
(5,12),
(6,13),
(6,14),
(7,15),
(8,16),
(8,17),
(8,18),
(9,19),
(9,20),
(9,21),
(9,22),
(10,23),
(11,24),
(12,25),
(13,26);

-- HOLIDAY  ===================================================================
INSERT INTO `holiday` VALUES
('Columbus Day', '2017-10-09', 2),
('Thanksgiving Day', '2017-11-23', 5),
('Christmas Day', '2017-12-25', 10);

-- AVAILABILITY  ==============================================================
INSERT INTO `availability` VALUES
(1, '2017-09-24', 1),
(1, '2017-09-25', 2),
(1, '2017-09-26', 1),
(1, '2017-09-27', 3),
(1, '2017-09-28', 1),
(1, '2017-09-29', 2),
(1, '2017-09-30', 1),
(2, '2017-09-24', 2),
(2, '2017-09-25', 1),
(2, '2017-09-26', 3),
(2, '2017-09-27', 1),
(2, '2017-09-28', 2),
(2, '2017-09-29', 1),
(2, '2017-09-30', 3),
(3, '2017-09-24', 2),
(3, '2017-09-25', 2),
(3, '2017-09-26', 2),
(3, '2017-09-27', 2),
(3, '2017-09-28', 2),
(3, '2017-09-29', 2),
(3, '2017-09-30', 2),
(4, '2017-09-24', 3),
(4, '2017-09-25', 3),
(4, '2017-09-26', 3),
(4, '2017-09-27', 3),
(4, '2017-09-28', 3),
(4, '2017-09-29', 3),
(4, '2017-09-30', 3),
(5, '2017-09-24', 2),
(5, '2017-09-25', 2),
(5, '2017-09-26', 3),
(5, '2017-09-27', 2),
(5, '2017-09-28', 1),
(5, '2017-09-29', 2),
(5, '2017-09-30', 1),
(6, '2017-09-24', 1),
(6, '2017-09-25', 3),
(6, '2017-09-26', 3),
(6, '2017-09-27', 3),
(6, '2017-09-28', 3),
(6, '2017-09-29', 3),
(6, '2017-09-30', 1);

-- BLACKOUT DATES  ============================================================
INSERT INTO `blackout_dates` VALUES
(1, '2017-09-24', '2017-09-30'),
(2, '2017-09-24', '2017-09-30'),
(3, '2017-10-01', '2017-10-07'),
(4, '2017-10-08', '2017-10-14'),
(5, '2017-10-15', '2017-10-21'),
(6, '2017-10-22', '2017-10-28'),
(7, '2017-10-29', '2017-11-04'),
(8, '2017-11-05', '2017-11-11'),
(9, '2017-11-12', '2017-11-18'),
(10, '2017-11-19', '2017-11-25'),
(11, '2017-11-26', '2017-12-02'),
(12, '2017-12-03', '2017-12-09'),
(13, '2017-12-10', '2017-12-16');

-- ROTATION  ==================================================================
INSERT INTO `rotation` VALUES
(0, 1, 1, '2017-11-05', '2017-11-11',1);