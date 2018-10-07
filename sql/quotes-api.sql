

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;



CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'science'),
(2, 'social'),
(3, 'programming'),
(4, 'religion'),
(5, 'politics');

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `id` int(11) NOT NULL,
  `body` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`id`, `body`, `user_id`, `category_id`, `date`) VALUES
(1, 'in tempus sit amet sem fusce consequat nulla nisl nunc nisl duis bibendum felis sed interdum venenatis turpis enim blandit mi in porttitor pede justo eu', 1, 1, '26/03/2018'),
(2, 'lorem da al  askdf asjfa asklfd a adkjas  daskljas  dfkjfsd a asdfkl ', 6, 2, '18/12/2017'),
(3, 'vel enim sit amet nunc viverra dapibus nulla suscipit ligula in lacus curabitur at ipsum ac tellus semper interdum mauris ullamcorper purus sit amet nulla quisque arcu libero rutrum ac lobortis vel', 36, 1, '19/12/2017'),
(4, 'curae donec pharetra magna vestibulum aliquet ultrices erat tortor sollicitudin mi sit amet lobortis sapien sapien non mi integer ac neque duis bibendum morbi non quam nec dui luctus rutrum nulla tellus in sagittis dui vel nisl duis ac nibh fusce lacus purus aliquet at feugiat non pretium quis lectus suspendisse potenti', 25, 1, '28/11/2017'),
(5, 'sed accumsan felis ut at dolor quis odio consequat varius integer ac leo pellentesque ultrices mattis odio donec vitae nisi nam ultrices libero non mattis pulvinar nulla pede ullamcorper', 29, 1, '06/01/2018'),
(6, 'leo odio porttitor id consequat in consequat ut nulla sed accumsan felis ut at dolor quis odio consequat varius integer ac leo', 50, 2, '10/08/2018'),
(7, 'ultrices libero non mattis pulvinar nulla pede ullamcorper augue a suscipit nulla elit ac nulla sed vel enim sit amet nunc viverra dapibus nulla suscipit ligula in lacus curabitur at ipsum ac tellus semper interdum mauris ullamcorper purus sit amet nulla quisque', 41, 5, '07/03/2018'),
(8, 'bibendum felis sed interdum venenatis turpis enim blandit mi in porttitor pede justo eu massa donec dapibus duis at velit eu est congue elementum in hac habitasse platea dictumst morbi vestibulum velit id pretium iaculis diam erat fermentum justo nec condimentum neque sapien placerat', 5, 4, '05/09/2018'),
(9, 'at turpis donec posuere metus vitae ipsum aliquam non mauris morbi non lectus aliquam sit amet diam in magna bibendum imperdiet nullam orci pede venenatis non sodales sed tincidunt eu felis fusce posuere felis sed lacus morbi sem mauris laoreet ut', 45, 5, '15/10/2017'),
(10, 'eu nibh quisque id justo sit amet sapien dignissim vestibulum vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae nulla dapibus dolor vel est donec odio justo sollicitudin ut suscipit a feugiat et eros vestibulum ac est lacinia nisi venenatis tristique fusce congue diam id', 8, 4, '02/09/2018'),
(11, 'molestie hendrerit at vulputate vitae nisl aenean lectus pellentesque eget nunc donec quis orci eget orci vehicula condimentum curabitur in libero ut', 32, 3, '01/06/2018'),
(12, 'tincidunt eget tempus vel pede morbi porttitor lorem id ligula suspendisse ornare', 5, 1, '16/12/2017'),
(13, 'erat id mauris vulputate elementum nullam varius nulla facilisi cras non velit nec nisi vulputate nonummy maecenas tincidunt lacus at velit vivamus vel nulla eget eros elementum pellentesque quisque porta volutpat erat quisque erat eros viverra eget', 28, 3, '28/06/2018'),
(14, 'phasellus sit amet erat nulla tempus vivamus in felis eu sapien cursus vestibulum proin eu mi nulla ac enim in tempor turpis nec euismod scelerisque quam turpis adipiscing lorem vitae mattis nibh ligula nec sem duis aliquam convallis nunc proin at turpis a pede posuere nonummy integer non velit donec diam neque vestibulum eget vulputate ut ultrices vel augue', 25, 3, '07/05/2018'),
(15, 'sapien sapien non mi integer ac neque duis bibendum morbi non quam nec dui luctus rutrum nulla tellus in sagittis dui vel nisl duis ac nibh fusce lacus purus aliquet at feugiat non pretium quis lectus suspendisse potenti in eleifend quam a odio', 38, 1, '22/12/2017'),
(16, 'dapibus augue vel accumsan tellus nisi eu orci mauris lacinia sapien quis libero nullam sit amet turpis elementum ligula vehicula consequat morbi a ipsum', 22, 4, '02/03/2018'),
(17, 'sollicitudin mi sit amet lobortis sapien sapien non mi integer ac neque duis bibendum morbi non quam nec dui luctus rutrum nulla tellus in sagittis', 18, 2, '13/09/2017'),
(18, 'rutrum at lorem integer tincidunt ante vel ipsum praesent blandit lacinia erat vestibulum sed magna at nunc commodo placerat praesent blandit nam nulla integer pede justo lacinia eget tincidunt eget tempus vel pede', 16, 2, '23/12/2017'),
(19, 'aliquet maecenas leo odio condimentum id luctus nec molestie sed justo pellentesque viverra pede ac diam cras pellentesque volutpat dui maecenas tristique est et tempus semper est quam pharetra magna ac consequat metus sapien ut nunc vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae mauris viverra diam vitae quam suspendisse potenti nullam porttitor lacus', 42, 4, '05/06/2018'),
(20, 'varius ut blandit non interdum in ante vestibulum ante ipsum primis in faucibus orci luctus et', 47, 1, '02/02/2018'),
(21, 'tincidunt eget tempus vel pede morbi porttitor lorem id ligula suspendisse ornare consequat lectus in est risus auctor sed tristique in tempus sit amet sem fusce consequat nulla nisl nunc nisl duis bibendum felis sed interdum venenatis turpis enim blandit mi in porttitor pede justo eu massa donec dapibus duis at velit eu est congue elementum in hac', 43, 1, '05/09/2018'),
(22, 'arcu adipiscing molestie hendrerit at vulputate vitae nisl aenean lectus pellentesque eget nunc donec quis orci eget orci vehicula condimentum curabitur in libero ut massa volutpat convallis morbi odio odio elementum', 31, 1, '21/10/2017'),
(23, 'eu est congue elementum in hac habitasse platea dictumst morbi vestibulum velit id pretium iaculis diam erat fermentum justo nec condimentum neque sapien placerat ante nulla justo aliquam quis turpis eget elit sodales scelerisque mauris sit', 43, 3, '10/06/2018'),
(24, 'bibendum felis sed interdum venenatis turpis enim blandit mi in porttitor pede justo eu massa donec dapibus duis at velit eu est congue elementum in hac habitasse platea dictumst morbi vestibulum velit id pretium iaculis diam erat fermentum justo nec condimentum neque sapien placerat ante nulla justo aliquam quis turpis eget', 1, 5, '21/02/2018'),
(25, 'est donec odio justo sollicitudin ut suscipit a feugiat et eros vestibulum ac est lacinia nisi venenatis tristique fusce congue diam id ornare imperdiet sapien urna pretium nisl ut volutpat sapien arcu sed augue aliquam erat volutpat in congue etiam justo etiam pretium iaculis justo', 38, 4, '05/02/2018'),
(26, 'neque sapien placerat ante nulla justo aliquam quis turpis eget elit sodales scelerisque mauris sit amet eros suspendisse accumsan tortor quis turpis sed ante vivamus tortor duis mattis egestas metus aenean fermentum donec ut mauris eget massa tempor convallis nulla neque libero convallis eget eleifend luctus ultricies', 1, 3, '09/07/2018'),
(27, 'justo pellentesque viverra pede ac diam cras pellentesque volutpat dui maecenas tristique est et tempus semper est quam pharetra', 13, 3, '01/08/2018'),
(28, 'fusce congue diam id ornare imperdiet sapien urna pretium nisl ut volutpat sapien arcu sed augue aliquam erat volutpat in congue etiam justo etiam pretium iaculis justo in hac habitasse platea dictumst etiam faucibus cursus urna ut tellus nulla ut erat id mauris vulputate elementum nullam varius', 41, 4, '03/04/2018'),
(29, 'integer pede justo lacinia eget tincidunt eget tempus vel pede morbi porttitor lorem id ligula', 4, 1, '07/05/2018'),
(30, 'in felis eu sapien cursus vestibulum proin eu mi nulla ac enim in tempor turpis nec euismod scelerisque quam turpis adipiscing lorem vitae mattis nibh ligula nec sem duis aliquam convallis nunc proin at turpis a pede posuere nonummy integer non', 29, 5, '19/01/2018'),
(31, 'eget vulputate ut ultrices vel augue vestibulum ante ipsum primis in faucibus', 37, 3, '09/05/2018'),
(32, 'nulla ac enim in tempor turpis nec euismod scelerisque quam turpis adipiscing lorem vitae mattis nibh ligula nec sem duis aliquam convallis nunc proin at turpis a pede posuere nonummy integer non velit donec diam neque vestibulum eget vulputate ut ultrices vel augue vestibulum ante ipsum primis in faucibus orci luctus et', 32, 4, '11/06/2018'),
(33, 'suscipit a feugiat et eros vestibulum ac est lacinia nisi venenatis tristique fusce congue diam id ornare imperdiet sapien urna pretium nisl ut volutpat sapien arcu', 42, 4, '27/09/2017'),
(34, 'in purus eu magna vulputate luctus cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus vivamus vestibulum sagittis sapien cum sociis natoque penatibus', 34, 5, '14/06/2018'),
(35, 'in hac habitasse platea dictumst morbi vestibulum velit id pretium iaculis diam erat fermentum', 3, 5, '01/06/2018'),
(36, 'diam id ornare imperdiet sapien urna pretium nisl ut volutpat sapien arcu sed augue aliquam', 18, 2, '16/05/2018'),
(37, 'ut tellus nulla ut erat id mauris vulputate elementum nullam varius nulla facilisi cras non velit nec nisi vulputate nonummy maecenas tincidunt lacus at velit vivamus vel nulla eget eros elementum pellentesque quisque porta volutpat erat quisque', 35, 3, '13/09/2017'),
(38, 'turpis a pede posuere nonummy integer non velit donec diam neque vestibulum eget vulputate ut ultrices vel augue vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae donec pharetra magna vestibulum aliquet ultrices erat tortor sollicitudin mi sit amet lobortis sapien sapien non mi integer', 23, 5, '05/06/2018'),
(39, 'pede morbi porttitor lorem id ligula suspendisse ornare consequat lectus in est risus auctor sed tristique in tempus sit amet', 48, 3, '02/03/2018'),
(40, 'quam sollicitudin vitae consectetuer eget rutrum at lorem integer tincidunt ante vel ipsum praesent blandit lacinia erat vestibulum sed', 46, 5, '05/07/2018'),
(41, 'ligula nec sem duis aliquam convallis nunc proin at turpis a pede posuere nonummy integer non velit donec diam neque vestibulum eget vulputate ut ultrices vel augue vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae donec pharetra magna', 14, 3, '04/01/2018'),
(42, 'neque sapien placerat ante nulla justo aliquam quis turpis eget elit sodales scelerisque mauris sit amet eros', 44, 1, '31/12/2017'),
(43, 'proin at turpis a pede posuere nonummy integer non velit donec diam neque vestibulum eget vulputate ut ultrices vel augue vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae donec pharetra magna vestibulum aliquet ultrices erat tortor sollicitudin mi sit amet lobortis', 23, 5, '27/06/2018'),
(44, 'sed interdum venenatis turpis enim blandit mi in porttitor pede justo eu massa donec dapibus duis at velit eu est congue elementum in hac habitasse platea dictumst morbi vestibulum velit id pretium iaculis diam erat fermentum', 14, 5, '17/12/2017'),
(45, 'molestie lorem quisque ut erat curabitur gravida nisi at nibh in hac habitasse platea dictumst aliquam augue quam sollicitudin vitae consectetuer eget rutrum at lorem integer tincidunt ante vel ipsum praesent blandit lacinia erat vestibulum sed magna at nunc commodo placerat praesent blandit nam nulla integer pede', 39, 3, '08/03/2018'),
(46, 'duis aliquam convallis nunc proin at turpis a pede posuere nonummy integer non velit donec diam neque vestibulum eget vulputate ut ultrices vel augue vestibulum', 39, 1, '24/07/2018'),
(47, 'eu nibh quisque id justo sit amet sapien dignissim vestibulum vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae nulla dapibus dolor vel est donec odio justo sollicitudin ut suscipit a feugiat et eros vestibulum ac est lacinia nisi venenatis tristique fusce congue diam id ornare imperdiet', 15, 5, '23/07/2018'),
(48, 'magna vestibulum aliquet ultrices erat tortor sollicitudin mi sit amet lobortis sapien sapien non mi integer ac neque duis bibendum', 27, 3, '16/06/2018'),
(49, 'quis orci nullam molestie nibh in lectus pellentesque at nulla suspendisse potenti cras in', 38, 4, '05/10/2017'),
(50, 'sit amet sapien dignissim vestibulum vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae nulla dapibus dolor vel est donec odio justo sollicitudin ut suscipit a feugiat et eros vestibulum ac est lacinia nisi venenatis tristique fusce congue diam id ornare imperdiet sapien urna pretium nisl ut volutpat sapien arcu sed augue aliquam erat volutpat in', 26, 3, '22/10/2017'),
(51, 'tristique in tempus sit amet sem fusce consequat nulla nisl nunc nisl duis bibendum felis sed interdum venenatis turpis enim blandit mi in porttitor pede justo eu massa donec dapibus duis at velit eu est congue elementum in hac habitasse platea dictumst morbi vestibulum velit id pretium iaculis diam erat fermentum justo nec', 4, 4, '01/05/2018'),
(52, 'blandit mi in porttitor pede justo eu massa donec dapibus duis at velit eu est congue elementum in', 36, 1, '07/08/2018'),
(53, 'mus etiam vel augue vestibulum rutrum rutrum neque aenean auctor gravida sem praesent id massa id nisl venenatis lacinia aenean sit amet justo morbi ut odio cras mi pede', 29, 1, '11/09/2017'),
(54, 'eleifend quam a odio in hac habitasse platea dictumst maecenas ut massa quis augue luctus tincidunt nulla mollis', 34, 3, '02/05/2018'),
(55, 'vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae donec pharetra magna vestibulum aliquet ultrices erat tortor sollicitudin mi sit amet lobortis sapien sapien non mi integer ac neque duis bibendum morbi non quam nec dui luctus rutrum nulla tellus in', 19, 1, '17/02/2018'),
(56, 'tincidunt ante vel ipsum praesent blandit lacinia erat vestibulum sed magna at nunc commodo placerat praesent blandit nam nulla integer pede', 25, 2, '18/10/2017'),
(57, 'lacus purus aliquet at feugiat non pretium quis lectus suspendisse potenti in eleifend quam a odio in hac habitasse platea dictumst maecenas ut massa quis augue luctus tincidunt nulla mollis molestie lorem quisque ut erat curabitur gravida nisi at nibh in hac habitasse platea dictumst aliquam augue quam sollicitudin vitae consectetuer eget rutrum at lorem integer tincidunt ante', 30, 5, '10/10/2017'),
(58, 'sed augue aliquam erat volutpat in congue etiam justo etiam pretium iaculis justo in hac habitasse platea dictumst etiam faucibus cursus urna ut tellus nulla ut', 22, 2, '15/02/2018'),
(59, 'tortor id nulla ultrices aliquet maecenas leo odio condimentum id luctus nec molestie sed justo pellentesque viverra pede ac diam cras pellentesque volutpat dui maecenas tristique est et tempus semper est quam pharetra magna ac consequat metus sapien ut nunc vestibulum', 20, 4, '22/11/2017'),
(60, 'ac consequat metus sapien ut nunc vestibulum ante ipsum primis', 20, 4, '09/12/2017'),
(61, 'nunc vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae mauris viverra diam vitae quam suspendisse potenti nullam porttitor lacus at turpis donec posuere metus vitae ipsum aliquam non mauris morbi non lectus aliquam sit amet diam in magna bibendum imperdiet nullam', 27, 4, '09/02/2018'),
(62, 'elementum nullam varius nulla facilisi cras non velit nec nisi vulputate nonummy maecenas tincidunt lacus at velit vivamus vel nulla eget eros elementum pellentesque quisque porta volutpat erat quisque erat eros viverra eget congue eget semper rutrum nulla nunc purus phasellus in felis donec semper sapien a libero nam dui proin leo odio porttitor', 30, 1, '31/07/2018'),
(63, 'magna bibendum imperdiet nullam orci pede venenatis non sodales sed tincidunt eu felis fusce posuere felis sed lacus morbi sem mauris laoreet ut rhoncus aliquet pulvinar sed nisl nunc rhoncus', 26, 5, '19/04/2018'),
(64, 'quis justo maecenas rhoncus aliquam lacus morbi quis tortor id nulla ultrices aliquet maecenas leo odio condimentum id luctus nec molestie sed justo pellentesque viverra pede ac diam cras pellentesque volutpat dui maecenas tristique est et tempus semper est quam pharetra', 33, 4, '04/04/2018'),
(65, 'in hac habitasse platea dictumst morbi vestibulum velit id pretium iaculis diam erat fermentum justo nec condimentum neque sapien placerat ante nulla justo aliquam quis turpis eget elit sodales scelerisque mauris sit amet eros suspendisse accumsan tortor quis', 23, 4, '05/10/2017'),
(66, 'aliquet maecenas leo odio condimentum id luctus nec molestie sed justo pellentesque viverra pede ac diam cras pellentesque volutpat dui maecenas tristique est et tempus semper est quam pharetra magna ac consequat metus sapien ut nunc vestibulum ante ipsum primis in faucibus', 16, 1, '21/04/2018'),
(67, 'elit ac nulla sed vel enim sit amet nunc viverra dapibus nulla suscipit ligula in lacus curabitur at ipsum ac tellus semper interdum mauris ullamcorper purus sit amet nulla quisque arcu libero rutrum ac', 35, 2, '10/11/2017'),
(68, 'justo morbi ut odio cras mi pede malesuada in imperdiet et commodo vulputate justo in blandit ultrices enim lorem ipsum dolor sit amet consectetuer adipiscing elit proin interdum mauris non ligula pellentesque ultrices phasellus id sapien in sapien', 49, 5, '07/11/2017'),
(69, 'vestibulum eget vulputate ut ultrices vel augue vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae donec pharetra magna vestibulum aliquet ultrices erat tortor sollicitudin mi sit amet lobortis sapien sapien non mi integer ac neque duis bibendum morbi non quam nec', 5, 3, '18/07/2018'),
(70, 'quis orci eget orci vehicula condimentum curabitur in libero ut massa volutpat convallis morbi odio odio elementum eu interdum eu tincidunt in leo maecenas pulvinar lobortis est phasellus', 10, 4, '15/11/2017'),
(71, 'semper est quam pharetra magna ac consequat metus sapien ut nunc vestibulum ante ipsum primis in', 8, 5, '09/04/2018'),
(72, 'vestibulum quam sapien varius ut blandit non interdum in ante vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae duis faucibus accumsan odio curabitur convallis duis consequat dui nec nisi volutpat eleifend donec ut dolor morbi vel lectus in quam fringilla rhoncus mauris enim leo rhoncus sed vestibulum sit amet cursus id turpis', 31, 2, '04/12/2017'),
(73, 'blandit mi in porttitor pede justo eu massa donec dapibus duis at velit eu est congue elementum in hac habitasse platea dictumst morbi vestibulum velit id pretium iaculis diam erat fermentum justo nec condimentum neque sapien placerat ante nulla justo aliquam quis turpis eget elit sodales scelerisque mauris sit amet eros suspendisse accumsan tortor quis turpis sed ante vivamus tortor', 6, 1, '04/11/2017'),
(74, 'sed lacus morbi sem mauris laoreet ut rhoncus aliquet pulvinar sed nisl nunc rhoncus dui vel sem sed sagittis nam congue risus semper porta volutpat quam pede lobortis ligula sit amet eleifend pede libero quis orci nullam molestie nibh in lectus pellentesque at nulla suspendisse potenti cras in purus eu magna vulputate luctus cum sociis natoque penatibus et', 39, 3, '22/07/2018'),
(75, 'mauris vulputate elementum nullam varius nulla facilisi cras non velit nec nisi vulputate nonummy maecenas tincidunt lacus at velit vivamus vel nulla eget eros elementum pellentesque quisque porta volutpat erat quisque erat eros viverra eget congue eget semper rutrum nulla nunc', 39, 4, '29/09/2017'),
(76, 'ultrices posuere cubilia curae donec pharetra magna vestibulum aliquet ultrices erat tortor sollicitudin mi sit amet lobortis sapien sapien non mi integer ac neque duis bibendum morbi', 45, 3, '23/12/2017'),
(77, 'nunc vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae mauris', 24, 3, '27/11/2017'),
(78, 'erat fermentum justo nec condimentum neque sapien placerat ante nulla justo aliquam quis turpis eget elit sodales scelerisque mauris sit amet eros suspendisse accumsan tortor quis turpis sed ante vivamus tortor duis mattis egestas metus aenean fermentum donec ut mauris', 31, 2, '16/10/2017'),
(79, 'nunc proin at turpis a pede posuere nonummy integer non velit donec diam neque vestibulum eget vulputate ut ultrices vel augue vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae donec pharetra magna vestibulum aliquet ultrices erat tortor sollicitudin mi sit amet lobortis sapien sapien non mi integer ac neque duis bibendum morbi non quam nec', 17, 3, '08/12/2017'),
(80, 'tellus nisi eu orci mauris lacinia sapien quis libero nullam sit amet turpis elementum ligula vehicula consequat morbi a ipsum integer a nibh', 22, 1, '26/01/2018'),
(81, 'faucibus orci luctus et ultrices posuere cubilia curae donec pharetra magna vestibulum aliquet ultrices erat tortor sollicitudin mi sit amet lobortis sapien sapien non mi integer ac neque duis bibendum morbi non quam nec', 35, 4, '31/10/2017'),
(82, 'et commodo vulputate justo in blandit ultrices enim lorem ipsum dolor sit amet consectetuer adipiscing elit proin interdum mauris non ligula pellentesque ultrices phasellus id sapien in sapien iaculis congue vivamus metus arcu adipiscing', 25, 3, '05/09/2018'),
(83, 'sit amet eleifend pede libero quis orci nullam molestie nibh in lectus pellentesque at nulla suspendisse potenti cras in purus eu magna vulputate luctus cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus vivamus vestibulum sagittis sapien cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus etiam vel augue', 33, 3, '15/04/2018'),
(84, 'eu tincidunt in leo maecenas pulvinar lobortis est phasellus sit amet erat nulla tempus vivamus in felis eu sapien cursus vestibulum proin eu mi nulla ac enim in tempor turpis nec', 9, 5, '10/01/2018'),
(85, 'donec diam neque vestibulum eget vulputate ut ultrices vel augue vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae donec pharetra magna vestibulum aliquet ultrices erat tortor sollicitudin mi sit amet lobortis sapien sapien non mi integer ac neque duis bibendum', 31, 2, '12/08/2018'),
(86, 'quisque ut erat curabitur gravida nisi at nibh in hac habitasse platea dictumst aliquam augue quam sollicitudin vitae consectetuer eget rutrum at lorem integer tincidunt ante vel ipsum praesent blandit lacinia erat vestibulum sed magna at nunc commodo placerat praesent blandit nam nulla integer pede justo lacinia eget tincidunt eget tempus vel pede morbi', 14, 2, '27/07/2018'),
(87, 'mauris non ligula pellentesque ultrices phasellus id sapien in sapien iaculis congue vivamus metus arcu adipiscing molestie hendrerit at vulputate vitae nisl aenean lectus pellentesque eget nunc donec quis orci eget orci', 47, 3, '07/12/2017'),
(88, 'congue vivamus metus arcu adipiscing molestie hendrerit at vulputate vitae nisl aenean lectus pellentesque eget nunc donec quis orci eget orci vehicula condimentum curabitur in libero ut massa volutpat convallis morbi', 16, 2, '20/09/2017'),
(89, 'quis turpis eget elit sodales scelerisque mauris sit amet eros suspendisse accumsan tortor quis turpis sed ante vivamus tortor duis mattis egestas metus aenean fermentum donec ut mauris', 9, 1, '24/02/2018'),
(90, 'sit amet sem fusce consequat nulla nisl nunc nisl duis bibendum felis sed interdum venenatis turpis enim blandit mi in porttitor pede justo eu massa donec dapibus duis at velit eu est congue elementum in', 14, 1, '21/12/2017'),
(91, 'phasellus in felis donec semper sapien a libero nam dui proin leo odio porttitor id consequat in consequat ut nulla sed accumsan', 38, 1, '19/04/2018'),
(92, 'luctus et ultrices posuere cubilia curae donec pharetra magna vestibulum aliquet ultrices erat tortor', 18, 2, '10/09/2017'),
(93, 'donec quis orci eget orci vehicula condimentum curabitur in libero ut massa volutpat convallis morbi odio odio elementum eu interdum eu tincidunt in leo maecenas pulvinar lobortis est phasellus sit amet', 4, 1, '15/05/2018'),
(94, 'sit amet sem fusce consequat nulla nisl nunc nisl duis bibendum felis sed interdum', 32, 2, '10/12/2017'),
(95, 'lacinia nisi venenatis tristique fusce congue diam id ornare imperdiet sapien urna pretium nisl ut volutpat sapien arcu sed augue aliquam erat', 8, 5, '20/07/2018'),
(96, 'sodales sed tincidunt eu felis fusce posuere felis sed lacus morbi sem mauris laoreet ut rhoncus aliquet pulvinar sed nisl nunc rhoncus dui vel sem sed sagittis nam congue risus semper', 11, 1, '14/05/2018'),
(97, 'turpis elementum ligula vehicula consequat morbi a ipsum integer a nibh in quis justo maecenas rhoncus aliquam lacus morbi quis tortor id nulla ultrices aliquet maecenas leo odio condimentum id luctus nec molestie sed justo pellentesque viverra pede ac diam cras pellentesque', 36, 1, '10/11/2017'),
(98, 'dolor morbi vel lectus in quam fringilla rhoncus mauris enim leo rhoncus sed vestibulum sit amet cursus id turpis integer aliquet massa id lobortis convallis tortor risus dapibus augue vel accumsan tellus nisi eu orci mauris lacinia sapien quis libero nullam sit amet turpis elementum ligula vehicula consequat morbi', 41, 2, '20/12/2017'),
(99, 'eu felis fusce posuere felis sed lacus morbi sem mauris laoreet ut rhoncus aliquet pulvinar sed nisl nunc rhoncus dui vel sem sed sagittis nam congue risus semper porta volutpat quam pede lobortis ligula sit amet eleifend pede libero quis orci nullam molestie nibh in', 16, 4, '25/10/2017'),
(100, 'non velit nec nisi vulputate nonummy maecenas tincidunt lacus at velit', 43, 1, '24/03/2018');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `plan` varchar(50) NOT NULL DEFAULT 'basic',
  `calls_made` int(11) NOT NULL DEFAULT '0',
  `time_start` varchar(255) NOT NULL DEFAULT '0',
  `time_end` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `username`, `password`, `plan`, `calls_made`, `time_start`, `time_end`) VALUES
(1, 'Reed', 'Pollicatt', 'reedpollicatt1', 'reedpollicatt1password', 'basic', 0, '0', '0'),
(2, 'Matilde', 'Rogans', 'matilderogans2', 'matilderogans2password', 'unlimited', 0, '0', '0'),
(3, 'Chip', 'Jolley', 'chipjolley3', 'chipjolley3password', 'unlimited', 0, '0', '0'),
(4, 'Elly', 'Cicccitti', 'ellycicccitti4', 'ellycicccitti4password', 'basic', 0, '0', '0'),
(5, 'Dulcinea', 'Batterham', 'dulcineabatterham5', 'dulcineabatterham5password', 'unlimited', 0, '0', '0'),
(6, 'Josie', 'Hanselmann', 'josiehanselmann6', 'josiehanselmann6password', 'unlimited', 0, '0', '0'),
(7, 'Selestina', 'Smogur', 'selestinasmogur7', 'selestinasmogur7password', 'basic', 0, '0', '0'),
(8, 'Caz', 'Ockendon', 'cazockendon8', 'cazockendon8password', 'unlimited', 0, '0', '0'),
(9, 'Melina', 'MacGilmartin', 'melinamacgilmartin9', 'melinamacgilmartin9password', 'basic', 0, '0', '0'),
(10, 'Barbaraanne', 'Freestone', 'barbaraannefreestone10', 'barbaraannefreestone10password', 'unlimited', 0, '0', '0'),
(11, 'Ricca', 'Luckings', 'riccaluckings11', 'riccaluckings11password', 'basic', 0, '0', '0'),
(12, 'Lamar', 'Probetts', 'lamarprobetts12', 'lamarprobetts12password', 'basic', 0, '0', '0'),
(13, 'Nicolis', 'Dubose', 'nicolisdubose13', 'nicolisdubose13password', 'unlimited', 0, '0', '0'),
(14, 'Alix', 'Grenshields', 'alixgrenshields14', 'alixgrenshields14password', 'basic', 0, '0', '0'),
(15, 'Curt', 'McWhannel', 'curtmcwhannel15', 'curtmcwhannel15password', 'basic', 0, '0', '0'),
(16, 'Devina', 'Benitti', 'devinabenitti16', 'devinabenitti16password', 'unlimited', 0, '0', '0'),
(17, 'Lexis', 'Tammadge', 'lexistammadge17', 'lexistammadge17password', 'unlimited', 0, '0', '0'),
(18, 'Ursula', 'Iacovini', 'ursulaiacovini18', 'ursulaiacovini18password', 'basic', 0, '0', '0'),
(19, 'Ailsun', 'Fay', 'ailsunfay19', 'ailsunfay19password', 'unlimited', 40, '1536392813', '1536479213'),
(20, 'Casandra', 'Bowstead', 'casandrabowstead20', 'casandrabowstead20password', 'unlimited', 0, '0', '0'),
(21, 'Field', 'Haucke', 'fieldhaucke21', 'fieldhaucke21password', 'basic', 0, '0', '0'),
(22, 'Lenore', 'Taylorson', 'lenoretaylorson22', 'lenoretaylorson22password', 'basic', 0, '0', '0'),
(23, 'Burg', 'Keirle', 'burgkeirle23', 'burgkeirle23password', 'basic', 0, '0', '0'),
(24, 'Mae', 'Hassall', 'maehassall24', 'maehassall24password', 'unlimited', 0, '0', '0'),
(25, 'Tiffi', 'How to preserve', 'tiffihow to preserve25', 'tiffihow to preserve25password', 'basic', 0, '0', '0'),
(26, 'Jone', 'Ibbitt', 'joneibbitt26', 'joneibbitt26password', 'basic', 0, '0', '0'),
(27, 'Annabal', 'Utteridge', 'annabalutteridge27', 'annabalutteridge27password', 'basic', 0, '0', '0'),
(28, 'Con', 'Dawnay', 'condawnay28', 'condawnay28password', 'unlimited', 0, '0', '0'),
(29, 'Nevins', 'Lowe', 'nevinslowe29', 'nevinslowe29password', 'unlimited', 0, '0', '0'),
(30, 'Merrie', 'Gothrup', 'merriegothrup30', 'merriegothrup30password', 'basic', 0, '0', '0'),
(31, 'Laura', 'Monery', 'lauramonery31', 'lauramonery31password', 'unlimited', 0, '0', '0'),
(32, 'Hartley', 'Zorn', 'hartleyzorn32', 'hartleyzorn32password', 'basic', 0, '0', '0'),
(33, 'Cthrine', 'Browne', 'cthrinebrowne33', 'cthrinebrowne33password', 'basic', 0, '0', '0'),
(34, 'Micki', 'Lesurf', 'mickilesurf34', 'mickilesurf34password', 'unlimited', 0, '0', '0'),
(35, 'Dixie', 'Mannakee', 'dixiemannakee35', 'dixiemannakee35password', 'basic', 0, '0', '0'),
(36, 'Berrie', 'Klement', 'berrieklement36', 'berrieklement36password', 'basic', 0, '0', '0'),
(37, 'Joel', 'Partener', 'joelpartener37', 'joelpartener37password', 'unlimited', 0, '0', '0'),
(38, 'Emlyn', 'Such', 'emlynsuch38', 'emlynsuch38password', 'unlimited', 0, '0', '0'),
(39, 'Rozella', 'Somerlie', 'rozellasomerlie39', 'rozellasomerlie39password', 'unlimited', 0, '0', '0'),
(40, 'Elliott', 'Fuentez', 'elliottfuentez40', 'elliottfuentez40password', 'unlimited', 0, '0', '0'),
(41, 'Laetitia', 'Mc Grath', 'laetitiamc grath41', 'laetitiamc grath41password', 'unlimited', 0, '0', '0'),
(42, 'Alisander', 'Hirthe', 'alisanderhirthe42', 'alisanderhirthe42password', 'basic', 11, '1536419901', '1536506301'),
(43, 'Doyle', 'Malimoe', 'doylemalimoe43', 'doylemalimoe43password', 'unlimited', 0, '0', '0'),
(44, 'Jacquelynn', 'Blaisdale', 'jacquelynnblaisdale44', 'jacquelynnblaisdale44password', 'unlimited', 0, '0', '0'),
(45, 'Gordan', 'Lumsden', 'gordanlumsden45', 'gordanlumsden45password', 'unlimited', 0, '0', '0'),
(46, 'Rance', 'Gatward', 'rancegatward46', 'rancegatward46password', 'basic', 0, '0', '0'),
(47, 'Orin', 'Clotworthy', 'orinclotworthy47', 'orinclotworthy47password', 'unlimited', 0, '0', '0'),
(48, 'Theodor', 'Bracco', 'theodorbracco48', 'theodorbracco48password', 'basic', 0, '0', '0'),
(49, 'Viola', 'Curlis', 'violacurlis49', 'violacurlis49password', 'basic', 0, '0', '0'),
(50, 'Pollyanna', 'Cromar', 'pollyannacromar50', 'pollyannacromar50password', 'basic', 0, '0', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
