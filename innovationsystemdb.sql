-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2023 at 05:30 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `innovationsystemdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `IDAdmin` varchar(15) NOT NULL,
  `AdminPassword` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`IDAdmin`, `AdminPassword`) VALUES
('0015059007', 'DendiSanjaya123');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `IDCateg` varchar(15) NOT NULL,
  `NameCateg` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`IDCateg`, `NameCateg`) VALUES
('Categ001', 'Thesis'),
('Categ002', 'Internship'),
('Categ003', 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `concentration`
--

CREATE TABLE `concentration` (
  `IDConc` varchar(15) NOT NULL,
  `NameConc` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `concentration`
--

INSERT INTO `concentration` (`IDConc`, `NameConc`) VALUES
('Conc001', 'Cyber Security'),
('Conc002', 'Management Information'),
('Conc003', 'Engineering and Business'),
('Conc004', 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `creator`
--

CREATE TABLE `creator` (
  `CreatorID` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `creator`
--

INSERT INTO `creator` (`CreatorID`) VALUES
('Cre0001'),
('Cre0002'),
('Cre0003'),
('Cre0004'),
('Cre0005'),
('Cre0006'),
('Cre0007'),
('Cre0008'),
('Cre0009'),
('Cre0010'),
('Cre0011'),
('Cre0012'),
('Cre0013'),
('Cre0014'),
('Cre0015'),
('Cre0016'),
('Cre0017'),
('Cre0018'),
('Cre0019'),
('Cre0020'),
('Cre0021'),
('Cre0022'),
('Cre0023'),
('Cre0024'),
('Cre0025'),
('Cre0026'),
('Cre0027'),
('Cre0028'),
('Cre0029'),
('Cre0030'),
('Cre0031'),
('Cre0032'),
('Cre0033');

-- --------------------------------------------------------

--
-- Table structure for table `creatoruser`
--

CREATE TABLE `creatoruser` (
  `CreatorID` varchar(15) NOT NULL,
  `IDUser` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `creatoruser`
--

INSERT INTO `creatoruser` (`CreatorID`, `IDUser`) VALUES
('Cre0001', '0004125053'),
('Cre0001', '1815091003'),
('Cre0001', '2015091033'),
('Cre0001', '2115091002'),
('Cre0001', '2115091011'),
('Cre0002', '0004012503'),
('Cre0002', '0004125076'),
('Cre0002', '2015091067'),
('Cre0002', '2115091055'),
('Cre0002', '2215091018'),
('Cre0002', '2315091042'),
('Cre0003', '0004125053'),
('Cre0003', '0004125076'),
('Cre0003', '1815091065'),
('Cre0003', '2315091070'),
('Cre0004', '0004125053'),
('Cre0004', '0004125412'),
('Cre0004', '2115091010'),
('Cre0005', '0004125099'),
('Cre0005', '1915091012'),
('Cre0005', '2015091022'),
('Cre0005', '2015091067'),
('Cre0005', '2016201023'),
('Cre0005', '2115091033'),
('Cre0005', '2115091055'),
('Cre0005', '2215091010'),
('Cre0006', '0004125412'),
('Cre0006', '1815091001'),
('Cre0006', '1815091002'),
('Cre0006', '1815091003'),
('Cre0007', '0004012503'),
('Cre0007', '0004125099'),
('Cre0007', '2315091002'),
('Cre0007', '2315091005'),
('Cre0007', '2315091010'),
('Cre0007', '2315091020'),
('Cre0007', '2315091022'),
('Cre0008', '0004125412'),
('Cre0008', '2016201023'),
('Cre0009', '0004125076'),
('Cre0009', '2015091011'),
('Cre0009', '2215091066'),
('Cre0010', '0004125099'),
('Cre0010', '1715091037'),
('Cre0010', '1815091028'),
('Cre0010', '1815091091'),
('Cre0010', '1815091099'),
('Cre0011', '0004012503'),
('Cre0011', '0004125076'),
('Cre0011', '0004125412'),
('Cre0011', '1615091029'),
('Cre0011', '1915091072'),
('Cre0011', '2015091099'),
('Cre0011', '2115091099'),
('Cre0012', '0004125076'),
('Cre0012', '1915091022'),
('Cre0012', '2015091016'),
('Cre0012', '2115091027'),
('Cre0013', '0004125053'),
('Cre0013', '1615091030'),
('Cre0013', '1915091002'),
('Cre0013', '2015091060'),
('Cre0013', '2015091069'),
('Cre0014', '0004125412'),
('Cre0014', '1815091007'),
('Cre0014', '1915091041'),
('Cre0014', '2115091073'),
('Cre0014', '2215091063'),
('Cre0014', '2315091072'),
('Cre0015', '0004125076'),
('Cre0015', '2015091001'),
('Cre0015', '2115091024'),
('Cre0015', '2215091054'),
('Cre0016', '0004125099'),
('Cre0016', '1915091003'),
('Cre0017', '0004012503'),
('Cre0017', '1815091006'),
('Cre0018', '0004125076'),
('Cre0018', '1815091002'),
('Cre0018', '1815091091'),
('Cre0019', '0004125053'),
('Cre0019', '0004125076'),
('Cre0019', '0004125099'),
('Cre0019', '2015091001'),
('Cre0019', '2015091067'),
('Cre0019', '2016201023'),
('Cre0020', '0004012503'),
('Cre0020', '2115091011'),
('Cre0020', '2115091024'),
('Cre0020', '2215091010'),
('Cre0020', '2315091005'),
('Cre0021', '0004125053'),
('Cre0021', '0004125412'),
('Cre0021', '1715091037'),
('Cre0021', '1915091022'),
('Cre0021', '2015091033'),
('Cre0021', '2015091099'),
('Cre0022', '0004125412'),
('Cre0022', '2115091010'),
('Cre0022', '2215091018'),
('Cre0022', '2215091063'),
('Cre0023', '0004125053'),
('Cre0023', '0004125099'),
('Cre0023', '2115091055'),
('Cre0024', '0004012503'),
('Cre0024', '2115091024'),
('Cre0024', '2115091099'),
('Cre0024', '2315091020'),
('Cre0024', '2315091042'),
('Cre0024', '2315091070'),
('Cre0024', '2315091072'),
('Cre0025', '0004125412'),
('Cre0025', '2015091069'),
('Cre0025', '2315091002'),
('Cre0026', '0004125076'),
('Cre0026', '1615091029'),
('Cre0026', '1615091030'),
('Cre0026', '1815091099'),
('Cre0026', '2015091016'),
('Cre0027', '0004012503'),
('Cre0027', '2015091022'),
('Cre0027', '2015091060'),
('Cre0027', '2115091073'),
('Cre0028', '0004125412'),
('Cre0028', '1915091012'),
('Cre0029', '0004125099'),
('Cre0029', '2115091010'),
('Cre0029', '2215091010'),
('Cre0029', '2315091010'),
('Cre0030', '0004125053'),
('Cre0030', '1815091001'),
('Cre0030', '1815091002'),
('Cre0030', '1815091005'),
('Cre0030', '1815091028'),
('Cre0030', '1815091065'),
('Cre0030', '1815091099'),
('Cre0031', '0004125076'),
('Cre0031', '2115091033'),
('Cre0031', '2115091055'),
('Cre0031', '2215091018'),
('Cre0031', '2315091002'),
('Cre0032', '0004125053'),
('Cre0032', '1915091002'),
('Cre0033', '0004125412'),
('Cre0033', '2015091011'),
('Cre0033', '2015091060'),
('Cre0033', '2115091011');

-- --------------------------------------------------------

--
-- Table structure for table `innovationdata`
--

CREATE TABLE `innovationdata` (
  `IDInnov` varchar(15) NOT NULL,
  `NameInnov` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `CreDate` date NOT NULL,
  `SubmDate` date NOT NULL,
  `Img` varchar(50) NOT NULL,
  `Link` varchar(50) NOT NULL,
  `Status` enum('Pending','Approve','Reject') NOT NULL,
  `IDCateg` varchar(15) NOT NULL,
  `IDConc` varchar(15) NOT NULL,
  `IDType` varchar(15) NOT NULL,
  `CreatorID` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `innovationdata`
--

INSERT INTO `innovationdata` (`IDInnov`, `NameInnov`, `Description`, `CreDate`, `SubmDate`, `Img`, `Link`, `Status`, `IDCateg`, `IDConc`, `IDType`, `CreatorID`) VALUES
('Inno0001', 'Sampah Terpadu', 'Sampah Terpadu is an innovation that is developing in the field of information management where the system will display data in the form of total waste that has been successfully recycled at each landfill in the province of Bali.', '2023-04-03', '2023-10-27', '', 'https://sampah.tepadu.com', 'Approve', 'Categ003', 'Conc002', 'Ty001', 'Cre0001'),
('Inno0002', 'Belanja Yuk?', 'Belanja Yuk? is a developing innovation in the business sector. The system displays a display in the form of a catalog where users can see items at affordable prices that would not otherwise be made ‘kanker’ as a short of kantong kering in Indonesia.', '2022-12-12', '2023-09-14', '', 'https://belanja.yuk.com', 'Approve', 'Categ003', 'Conc003', 'Ty003', 'Cre0002'),
('Inno0003', 'Thesis Explorer', 'Thesis Explorer is a cutting-edge desktop application designed to revolutionize the way researchers and students explore and analyze academic theses. This innovative system utilizes advanced algorithms and natural language processing techniques to provide users with a comprehensive platform for discovering, organizing, and extracting valuable insights from a vast collection of theses.', '2020-04-11', '2021-01-28', '', 'https:/thesis.explorer.com', 'Pending', 'Categ003', 'Conc002', 'Ty002', 'Cre0003'),
('Inno0004', 'Dis Cysec', 'Dis Cysec is a website that can make it easier for users to learn about disaster recovery in cyber securit', '2022-02-23', '2022-04-25', '', 'https:/dis.cysec.com', 'Approve', 'Categ003', 'Conc001', 'Ty001', 'Cre0004'),
('Inno0005', 'Uilapedia', 'Uilapedia is a website that offer a wide range of high-quality preloved tech. Sellers can easily list their items, while buyers can browse and purchase securely. ', '2022-08-11', '2023-05-27', '', 'https:/uilapedia.com', 'Approve', 'Categ003', 'Conc003', 'Ty003', 'Cre0005'),
('Inno0006', 'Go Train', 'Step into a world where transportation is reimagined, where cutting-edge technologies and visionary ideas converge to shape the way we move. Welcome to our captivating display of transportation innovation, where we invite you to witness the future unfold before your ', '2021-09-01', '2022-10-18', '', 'https:/go.train.com', 'Pending', 'Categ003', 'Conc003', 'Ty003', 'Cre0006'),
('Inno0007', 'Book: Open Your Heart', 'Open Your Heart is a collaborative work between lecturers and students who took the idea from Armada\'s song entitled Open Your Heart with the song lyrics: I have done various things for your life until I sacrificed my life. Open your heart, open it a little for me so that I can have you. ', '2023-01-12', '2023-03-30', '', 'https:/open.your.heart.com', 'Approve', 'Categ003', 'Conc004', 'Ty004', 'Cre0007'),
('Inno0008', 'GanesHealth', 'GanesHealth is an innovation that aims to provide health services for general students at Ganesha University of Education.', '2022-07-03', '2023-02-28', '', 'https:/ganeshealth.com', 'Approve', 'Categ002', 'Conc004', 'Ty002', 'Cre0008'),
('Inno0009', 'Perangkat IoT untuk Monitoring Kesehatan Pekerja', 'IoT Devices for Monitoring Worker Health\r\nDevelopment of IoT devices that monitor the health and safety of workers in the work environment, helping to reduce the risk of injury and illness.', '2022-11-11', '2023-03-29', '', 'https:/perangkat.iot.untuk.monitoring.kesehatan.pe', 'Reject', 'Categ003', 'Conc002', 'Ty002', 'Cre0009'),
('Inno0010', 'Technology Infrastructure Analysis (Zoom)', 'Zoom could analyze its technology infrastructure, including server capacity, network performance, and scalability. This analysis helps Zoom ensure a seamless user experience, identify potential bottlenecks, and plan for future growth.\r\n', '2022-10-10', '2023-01-08', '', 'https:/analysis.zoom.com', 'Approve', 'Categ003', 'Conc002', 'Ty004', 'Cre0010'),
('Inno0011', 'Sistem Analitik Prediktif', 'Implementation of a predictive analytics system that utilizes artificial intelligence to analyze sales data and forecast future market trends.', '2022-10-05', '2023-02-14', '', 'https:/sistem.analitik.prediktif.com', 'Approve', 'Categ003', 'Conc003', 'Ty003', 'Cre0011'),
('Inno0012', 'Platform Kolaborasi Online', 'Launch of an online collaboration platform that allows internal and external teams to work together on projects efficiently, regardless of physical location.', '2023-04-12', '2023-08-15', '', 'https:/platform.kolaborasi.com', 'Pending', 'Categ003', 'Conc002', 'Ty001', 'Cre0012'),
('Inno0013', 'Keamanan Jaringan yang Ditingkatkan', 'Improved company network security systems by installing advanced firewalls and stronger intrusion detection systems to protect sensitive data.', '2023-02-05', '2023-08-17', '', 'https:/keamanan.jaringan.yang.ditingkatkan.com', 'Approve', 'Categ003', 'Conc001', 'Ty004', 'Cre0013'),
('Inno0014', 'Aplikasi Pintar untuk Manajemen Proyek', 'Launch of a project management application that uses artificial intelligence to optimize schedules, resources and real-time project monitoring.', '2023-03-11', '2023-10-28', '', 'https:/aplikasi.pintar.untuk.manajemen.proyek.com', 'Approve', 'Categ003', 'Conc002', 'Ty003', 'Cre0014'),
('Inno0015', 'Lemari Buku', 'Lemari Buku is an innovation that aims to facilitate a digital reading space to increase users\' reading interest.', '2023-02-17', '2022-08-29', '', 'https:/lemari.buku.com', 'Reject', 'Categ003', 'Conc002', 'Ty003', 'Cre0015'),
('Inno0016', 'HIPC (Hidup Ini Penuh Cobaan) Katalog Struggle Mahasiswa SIFORS UNDIKSHA', 'Hidup Ini Penuh Cobaan is a an information system that contains all the stories and complaints of UNDIKSHA students while studying at this beloved campus, to improve the mental health of each student in the future for a brighter and healthier UNDIKSHA.', '2023-03-19', '2022-08-28', '', 'https://hipc.undiksha.ac.id', 'Approve', 'Categ001', 'Conc002', 'Ty001', 'Cre0016'),
('Inno0017', 'Integrasi Sistem Enterprise', 'Integration of all the company\'s enterprise systems into one single platform to increase operational efficiency and reduce redundancy.', '2023-07-23', '2023-09-30', '', 'https:/integrasi.sistem.enterprise.com', 'Reject', 'Categ002', 'Conc003', 'Ty002', 'Cre0017'),
('Inno0018', 'Algoritma Pencarian Cepat', 'Development of new search algorithms that can increase speed and accuracy in the data search process in company databases.', '2018-02-15', '2023-02-15', '', 'https:/Algoritma Pencarian Cepat.com', 'Reject', 'Categ003', 'Conc003', 'Ty001', 'Cre0018'),
('Inno0019', 'Sistem Informasi Keuangan Terintegras', 'Integration of all company financial information systems into one platform to facilitate monitoring, reporting and financial decision making', '2023-01-02', '2023-08-17', '', 'https:/Sistem Informasi Keuangan Terintegrasi.com', 'Approve', 'Categ003', 'Conc004', 'Ty002', 'Cre0019'),
('Inno0020', 'Layanan Cloud Computing Kustom', 'Development of custom cloud computing services to meet corporate computing and data storage needs more efficiently.\r\n', '2023-04-01', '2023-08-25', '', 'https:/Layanan Cloud Computing Kustom.com', 'Approve', 'Categ003', 'Conc003', 'Ty004', 'Cre0020'),
('Inno0021', 'Keamanan IoT yang Terintegrasi', 'Development of integrated security for Internet of Things (IoT) devices that protect data and systems from potential cyber threats', '2023-04-12', '2023-08-06', '', 'https:/Keamanan IoT yang Terintegrasi.com', 'Approve', 'Categ003', 'Conc001', 'Ty004', 'Cre0021'),
('Inno0022', 'Sistem Deteksi Serangan Lanjutan (Advanced Threat Detection)', 'Implement an attack detection system that uses behavioral analysis and artificial intelligence to identify more sophisticated cyberattacks and respond to them quickly.', '2023-02-03', '2023-04-18', '', 'https:/Sistem Deteksi Serangan Lanjutan .com', 'Approve', 'Categ003', 'Conc001', 'Ty004', 'Cre0022'),
('Inno0023', 'Balinese Aksara to English Translator', 'Balinese Aksara to English Translator is an innovation that aims to introduce Balinese script to the international stage so that people who go on holiday to Bali can easily translate Balinese script.', '2022-11-28', '2022-08-18', '', 'https:/balinese.aksara.to.english.translator.com', 'Approve', 'Categ003', 'Conc002', 'Ty003', 'Cre0023'),
('Inno0024', 'Analisis Risiko Keamanan Berbasis AI', 'Development of a security risk analysis system that utilizes artificial intelligence to identify potential risks and provide appropriate action recommendations.', '2022-04-05', '2023-09-19', '', 'https:/Analisis Risiko Keamanan Berbasis AI.com', 'Approve', 'Categ003', 'Conc001', 'Ty004', 'Cre0024'),
('Inno0025', 'Prioritize Yourself Over Other Things', 'Prioritize Yourself Over Other Things is an innovation that provides counseling services with a variety of experts who are combined to help you resolve a tangled thread.', '2020-01-07', '2021-05-29', '', 'https:/prioritize.yourself.over.other.things.com', 'Approve', 'Categ003', 'Conc003', 'Ty001', 'Cre0025'),
('Inno0026', 'Soulmelted', 'Do your friends often tease you because you are the only one among those who are dating? Don\'t worry, Soulmelted provides various types of choices that you can match to your preferences, just by swiping to the right you will get a girlfriend! of course at the same price, what are you waiting for? show off your girlfriend to your friends.\r\n\r\n', '2022-08-19', '2023-09-11', '', 'https:/soulmelted.com', 'Approve', 'Categ003', 'Conc004', 'Ty001', 'Cre0026'),
('Inno0027', 'Personal Colour Testing', 'Confused about which color suits your skin? We will help you find the color that will make your face brighter.', '2021-10-09', '2022-02-13', '', 'https:/personal.colour.testing.com', 'Approve', 'Categ003', 'Conc002', 'Ty003', 'Cre0027'),
('Inno0028', 'Love Me-ter', 'Calculate the accuracy and compatibility between you and your partner via Love Me-ter! Just write your name and your partner\'s name and you will immediately know the results', '2022-02-18', '2023-08-23', '', 'https:/love.meter.com', 'Approve', 'Categ003', 'Conc004', 'Ty001', 'Cre0028'),
('Inno0029', 'Resik Uapik', 'Resik Uapik is taken from Javanese language which mean clean and good that provides We provide cleaning services, there is no reason not to keep your home clean.', '2020-11-17', '2021-08-15', '', 'https:/resik.uapik.com', 'Approve', 'Categ003', 'Conc003', 'Ty003', 'Cre0029'),
('Inno0030', 'AMORA\r\nUI/UX Design Competition: Food and Beverage Edition\r\n', 'In order To open a new restaurant in the city center, AMORA is holding a UI/UX Design competition with a food and beverage theme which can be participated by the general public aged 18-25 years. The \'Ayo Dong Bantai Kami\' team won second place after presenting a topic that explored typical Yogyakarta regional food modified with elements of modernity without eliminating the existing traditional characteristics.', '2021-10-06', '2022-01-28', '', 'https:/ui.ux.f&b.com', 'Approve', 'Categ003', 'Conc004', 'Ty004', 'Cre0030'),
('Inno0031', 'FESTRA Business Plan Competition.', 'FESTRA also known as Festival Bahasa dan Sastra who held a business plan competition to hone students\' abilities to become more creative by developing ideas that have been given in accordance with the provisions listed. The \'Widih Kmie GG Bngitz\' team, which came from Information Systems Study Program students with four members, won first place with the theme \'Exploring Resources as a Movement in Striving for Sustainable Development Goals 2030.\'', '2022-12-20', '2023-08-23', '', 'https:/festra.buss.plan.com', 'Approve', 'Categ003', 'Conc003', 'Ty004', 'Cre0031'),
('Inno0032', 'TWEAK#8 Essay Competition ', 'BEM FTK holds an annual event to celebrate the faculty\'s birthday which opens with various competitions, the event is called Together We Stand for FTK. A student named Ida Ayu Gede Putri Audrey Aurethashafa Pramudya Winayaka won a silver medal for an essay with the theme: Just because I\'m stupid, am I not worthy of aiming as high as the sky?', '2023-05-23', '2023-09-13', '', 'https:/tweak.delapan.bem.ftk.2023.com', 'Approve', 'Categ003', 'Conc004', 'Ty004', 'Cre0032'),
('Inno0033', 'Cara Agar Tidak Mudah Marah', 'Cara Agar Tidak Mudah Marah is a collaborative masterpiece in the form of a book found in the public library of the Ganesha University of Education. The book raises topics originating from local research which found that the majority of people in the campus environment tend to have high temperament.', '2020-01-05', '2021-11-15', '', 'https:/cara.agar.tidak.mudah.marah.com', 'Approve', 'Categ003', 'Conc004', 'Ty004', 'Cre0033');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `IDType` varchar(15) NOT NULL,
  `NameType` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`IDType`, `NameType`) VALUES
('Ty001', 'Website'),
('Ty002', 'Desktop'),
('Ty003', 'MobileApp'),
('Ty004', 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `IDUser` varchar(10) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Role` enum('Student','Lecturer') NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `UserPass` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`IDUser`, `UserName`, `Role`, `Email`, `Phone`, `UserPass`) VALUES
('', '', '', '', '', ''),
('2115091011', 'Shympony', 'Student', 'melianti@student.undiksha.ac.id', '087761538903', 'Akusygkamu'),
('2115091002', 'Jeon Jungkook', 'Student', 'jungkook@student.undiksha.ac.id', '082144400892', 'bangtanot7'),
('2015091033', 'Anmulia Salatiga Semaradhana', 'Student', 'anmulia.salatiga@student.undiksha.ac.id', '089221329301', 'rizqieramadhana'),
('2115091010', 'Kurir Rempeyek', 'Student', 'namessayangchiaki@student.undiksa.ac.id', '082237450591', 'akukaya69'),
('0004125053', 'Arshello Malik', 'Lecturer', 'arshello@undiksha.ac.id', '085810725286', 'taliopsional'),
('0004012503', 'Scaramouche', 'Lecturer', 'scaramouche@undiksha.ac.id', '082192101102', 'scarasouche'),
('1815091003', 'Hidup Ini Penuh Cobaan', 'Student', 'hidup.ini@student.undiksha.ac.id', '08192291031', 'maintrampolin'),
('0004125076', 'Anarghya Mikael', 'Lecturer', 'anarghya@undiksha.ac.id', '082162964288', 'gakwarastonn'),
('2315091042', 'Anak Agung Muhammad Hezekiel Primantara ', 'Student', 'anak.agung.muhammad@student.undiksha.ac.id', '08291929101', 'yameteplease'),
('2015091067', 'Miles Kano Karnadi', 'Student', 'miles.kano@student.undiksha.ac.id', '088523994523', 'donat5k'),
('2215091018', 'Ginandra Nareswara', 'Student', 'ginandra.nareswara@student.undiksha.ac.id', '087257923476', 'aresjawir'),
('2115091055', 'Arjuna Sastradinata', 'Student', 'arjuna.sastradinata@student.undiksha.ac.id', '087249672134', 'bingungbanget'),
('1815091065', 'Matheo Mangkusadewo', 'Student', 'matheo@student.undiksha.ac.id', '082235446782', 'makanapaharini'),
('2315091070', 'Kayudha Arya Janitra', 'Student', 'kayudha.arya@student.undksha.ac.id', '087765653522', 'kayucoklat'),
('2215091010', 'Natama Demure ', 'Student', 'natama@student.undiksha.ac.id', '085810883215', 'escoklat'),
('1915091012', 'Raden Veda Suta Diningrat', 'Student', 'raden.veda@student.undiksha.ac.id', '081238867357', 'gagangpintu'),
('2016201023', 'Naruto Uzumaki', 'Student', 'naruto.uzumaki@student.undiksha.ac.id', '08193230121', 'sasukeuchiha'),
('0004125412', 'Reskala Auriga', 'Lecturer', 'reskala.auriga@undiksha.ac.id', '081239079834', 'qieiulovemartis'),
('0004125099', 'Kaito Wisesa', 'Lecturer', 'kaito@undiksha.ac.id', '082144007249', 'rafaeladoktersejati'),
('2015091022', 'Tjokorda Yohanes Gautama', 'Student', 'tjokorda.yohanes@student.undiksha.ac.id', '081232579574', 'chiakicikiwir'),
('2115091033', 'Haikal Naraya', 'Student', 'haikal.naraya@student.undiksha.ac.id', '08983158579', 'kipascosmos'),
('1815091001', 'Dewi Handayani', 'Student', 'dewi.handayani@student.undiksha.ac.id', '082239033190', 'mamazumba'),
('1815091002', 'Kariyani Sukerti', 'Student', 'kariyani.sukerti@student.undiksha.ac.id', '088137529627', 'sayangibunda'),
('1815091005', 'Afrilia Fondra Curniasari', 'Student', 'afrilia.fondra@student.undiksha.ac.id', '085862823272', 'mamibanana'),
('2315091002', 'Desta Maheswara', 'Student', 'desta.maheswara@student.undiksha.ac.id', '08279528326', 'udengtabanan'),
('2315091005', 'Septiasa Eka Mahayana', 'Student', 'septiasa@student.undiksha.ac.id', '08384585247', 'satudua3'),
('2315091010', 'Dian Anggraini', 'Student', 'dian.anggraini@student.undiksha.ac.id', '08315207931', 'cecanspensa'),
('2315091020', 'Arya Bumi Pancawikrama', 'Student', 'arya.bumi@student.undiksha.ac.id', '082147413799', 'jupiter29bulan'),
('2315091022', 'Adinda Melatie', 'Student', 'adinda.melatie@student.undiksha.ac.id', '08896348168', 'mawarmerah'),
('2215091066', 'Seto Mulyadi', 'Student', 'seto.mulyadi@student.undiksha.ac.id', '08291289109', 'pecintabalita'),
('2015091011', 'Le Sserafim', 'Student', 'le.sserafim@student.undiksha.ac.id', '08312239191', 'sakuramybeloved'),
('1815091099', 'Renata Adhiyaksa', 'Student', 'renata.adhiyaksa@student.undiksha.ac.id', '081338545292', 'lapsedfaith'),
('1715091037', 'Melody Nurramadhani Laksani', 'Student', 'melody@student.undiksha.ac.id', '082144409421', 'dirimumelody'),
('1815091028', 'Rayuan Pulau Kelapa', 'Student', 'rayuan@student.undiksha.ac.id', '089139193232', 'ismailmarzuki'),
('1815091091', 'Rangga Dewamoela', 'Student', 'rangga.dewamoela@student.undiksha.ac.id', '083929030332', 'smashnomor1'),
('2115091099', 'Samurai Ninja Mitsubishi', 'Student', 'samurai@student.undiksha.ac.id', '082921320211', 'ruroun1Kenshin'),
('2015091099', 'Iqbaal Ramadhan', 'Student', 'iqbaal@student.undiksha.ac.id', '081919392123', 'coboyjuniorea'),
('1915091072', 'Elsa Frozen', 'Student', 'elsa.frozen@student.undiksha.ac.id', '081329231101', 'bikinsnowman'),
('1615091029', 'Princess Aurora Rapunzel Cinderella Simanjuntak', 'Student', 'princess.aurora@student.undiksha.ac.id', '089382910221', 'snowwhite'),
('1915091022', 'Jang Anmulia Wonyoung', 'Student', 'jang.anmulia@student.undiksha.ac.id', '083912101112', 'afterlike'),
('2015091016', 'Aeri Uchinaga', 'Student', 'aeri@student.undiksha.ac.id', '082192110231', 'memberaespa'),
('2115091027', 'Kim Melianti Taehyung', 'Student', 'kim.melianti@student.undiksha.ac.id', '085019210113', 'taehyungoppa'),
('2015091060', 'Jeong Prameswari Jaehyun', 'Student', 'jeong.prameswari@student.undiksha.ac.id', '081920123341', 'jaehyunoppa'),
('1615091030', 'Anak Agung Gede Agung Abi Berlian Chaveiler Sapphire Kusumawangsa', 'Student', 'anak.agung.gede.agung.abi.berlian@student.undiksha', '082106291033', 'pearlmilktea'),
('1915091002', 'Ida Ayu Gede Putri Audrey Aurethashafa Pramudya Winayaka', 'Student', 'ida.ayu.gede.putri.audrey@student.undiksha.ac.id', '089201334201', 'shafaretha'),
('2015091069', 'Kalingga Adikara', 'Student', 'kalingga.adikara@student.undiksha.ac.id', '081336545482', 'spensupremacy'),
('2215091063', 'Erica Abimanyu', 'Student', 'erica.abimanyu@student.undiksha.ac.id', '082144019213', 'microsoftword'),
('2315091072', 'Cangkir Penuh Harapan Habis Beli Google Pixel', 'Student', 'cangkir.penuh@student.undiksha.ac.id', '089110212312', 'harapanpalsu'),
('1915091041', 'Cangkir Kosong Tanpa Kepastian', 'Student', 'cangkir.kosong@student.undiksha.ac.id', '088219201322', 'harapanpupus'),
('1815091007', 'Cangkir Setengah Penuh Penanda Esok Cerah Mentari', 'Student', 'cangkir@student.undiksha.ac.id', '087612920123', 'harapandoang'),
('2115091073', 'Giring Garong', 'Student', 'giring@student.undiksha.ac.id', '083120123123', 'laskarpelangi'),
('2215091054', 'Lisa Blackpink ', 'Student', 'lisa.blackpink@student.undiksha.ac.id', '085201133132', 'killthisheart'),
('2115091024', 'Names Twice Ambassador Samsung Galaxy Note Besik', 'Student', 'names.twice@student.undiksha.ac.id', '089102012303', 'whatisheart'),
('2015091001', 'Tut Wuri Dj Mahesa', 'Student', 'tut.wuri.handayani@student.undiksha.ac.id', '08102020132', 'naxpaskib'),
('1915091003', 'Tangkuban Perahu Fans Tajikistan', 'Student', 'tangkuban@student.undiksha.ac.id', '08911022131', 'sangkur1ang'),
('1815091006', 'Emmaleigh Haley Stewardess Sangkuriang', 'Student', 'emmaleigh@student.undiksha.ac.id', '082144409960', 'karenlove');

-- --------------------------------------------------------

--
-- Table structure for table `validation`
--

CREATE TABLE `validation` (
  `IDValid` varchar(15) NOT NULL,
  `IDInnov` varchar(15) NOT NULL,
  `Decision` enum('Approve','Reject') NOT NULL,
  `Note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `validation`
--

INSERT INTO `validation` (`IDValid`, `IDInnov`, `Decision`, `Note`) VALUES
('Val0001', 'Inno0001', 'Approve', ''),
('Val0002', 'Inno0002', 'Approve', ''),
('Val0004', 'Inno0004', 'Approve', ''),
('Val0005', 'Inno0005', 'Approve', ''),
('Val0007', 'Inno0007', 'Approve', ''),
('Val0008', 'Inno0008', 'Approve', ''),
('Val0009', 'Inno0009', 'Reject', 'Uploaded photos does not seem to match the invention given'),
('Val0010', 'Inno0010', 'Approve', ''),
('Val0011', 'Inno0011', 'Approve', ''),
('Val0013', 'Inno0013', 'Approve', ''),
('Val0014', 'Inno0014', 'Approve', ''),
('Val0015', 'Inno0015', 'Reject', 'Description contains SARA or other offending materials'),
('Val0016', 'Inno0016', 'Approve', ''),
('Val0017', 'Inno0017', 'Approve', ''),
('Val0018', 'Inno0018', 'Reject', 'A lecturer is wrongly labeled as a student'),
('Val0019', 'Inno0019', 'Approve', ''),
('Val0020', 'Inno0020', 'Approve', ''),
('Val0021', 'Inno0021', 'Approve', ''),
('Val0022', 'Inno0022', 'Approve', ''),
('Val0023', 'Inno0023', 'Approve', ''),
('Val0024', 'Inno0024', 'Approve', ''),
('Val0025', 'Inno0025', 'Approve', ''),
('Val0026', 'Inno0026', 'Approve', ''),
('Val0027', 'Inno0027', 'Approve', ''),
('Val0028', 'Inno0028', 'Approve', ''),
('Val0029', 'Inno0029', 'Approve', ''),
('Val0030', 'Inno0030', 'Approve', ''),
('Val0031', 'Inno0031', 'Approve', ''),
('Val0032', 'Inno0032', 'Approve', ''),
('Val0033', 'Inno0033', 'Approve', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`IDAdmin`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`IDCateg`);

--
-- Indexes for table `concentration`
--
ALTER TABLE `concentration`
  ADD PRIMARY KEY (`IDConc`);

--
-- Indexes for table `creator`
--
ALTER TABLE `creator`
  ADD PRIMARY KEY (`CreatorID`);

--
-- Indexes for table `creatoruser`
--
ALTER TABLE `creatoruser`
  ADD UNIQUE KEY `CreatorID` (`CreatorID`,`IDUser`);

--
-- Indexes for table `innovationdata`
--
ALTER TABLE `innovationdata`
  ADD PRIMARY KEY (`IDInnov`),
  ADD KEY `IDCateg` (`IDCateg`),
  ADD KEY `IDConc` (`IDConc`),
  ADD KEY `IDType` (`IDType`),
  ADD KEY `CreatorID` (`CreatorID`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`IDType`);

--
-- Indexes for table `validation`
--
ALTER TABLE `validation`
  ADD PRIMARY KEY (`IDValid`),
  ADD KEY `IDInnov` (`IDInnov`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `innovationdata`
--
ALTER TABLE `innovationdata`
  ADD CONSTRAINT `innovationdata_ibfk_1` FOREIGN KEY (`IDCateg`) REFERENCES `category` (`IDCateg`),
  ADD CONSTRAINT `innovationdata_ibfk_2` FOREIGN KEY (`IDConc`) REFERENCES `concentration` (`IDConc`),
  ADD CONSTRAINT `innovationdata_ibfk_3` FOREIGN KEY (`IDType`) REFERENCES `type` (`IDType`),
  ADD CONSTRAINT `innovationdata_ibfk_4` FOREIGN KEY (`CreatorID`) REFERENCES `creator` (`CreatorID`);

--
-- Constraints for table `validation`
--
ALTER TABLE `validation`
  ADD CONSTRAINT `validation_ibfk_1` FOREIGN KEY (`IDInnov`) REFERENCES `innovationdata` (`IDInnov`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
