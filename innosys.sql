-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2023 at 07:20 AM
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
-- Database: `innosys`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `IDAdmin` varchar(10) NOT NULL,
  `PasswordAdmin` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`IDAdmin`, `PasswordAdmin`) VALUES
('0015059007', 'DendiSanjaya123');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `IDCateg` int(10) NOT NULL,
  `NameCateg` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`IDCateg`, `NameCateg`) VALUES
(1, 'Thesis'),
(2, 'Internship'),
(3, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `concentration`
--

CREATE TABLE `concentration` (
  `IDConc` int(10) NOT NULL,
  `NameConc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `concentration`
--

INSERT INTO `concentration` (`IDConc`, `NameConc`) VALUES
(1, 'Cyber Security'),
(2, 'Management Information'),
(3, 'Engineering and Business'),
(4, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `innovdata`
--

CREATE TABLE `innovdata` (
  `IDInnov` int(10) NOT NULL,
  `NameInnov` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `Status` enum('Pending','Approve','Reject') NOT NULL,
  `SubmDate` date NOT NULL,
  `CreDate` date NOT NULL,
  `Link` varchar(50) NOT NULL,
  `Img` varchar(50) NOT NULL,
  `LinkYoutube` varchar(50) DEFAULT NULL,
  `IDConc` int(10) NOT NULL,
  `IDCateg` int(10) NOT NULL,
  `IDType` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `innovdata`
--

INSERT INTO `innovdata` (`IDInnov`, `NameInnov`, `Description`, `Status`, `SubmDate`, `CreDate`, `Link`, `Img`, `LinkYoutube`, `IDConc`, `IDCateg`, `IDType`) VALUES
(1, 'Sampah Ter', 'Sampah Terpadu is an innovation that is developing in the field of information management where the system will display data in the form of total waste that has been successfully recycled at each landfill in the province of Bali.\r\n', 'Approve', '2023-10-27', '2023-04-03', 'https://sampah.tepadu.com', '1.jpg, 1a.jpg, 1b.jpg', '', 2, 3, 1),
(2, 'Belanja Yu', 'Belanja Yuk? is a developing innovation in the business sector. The system displays a display in the form of a catalog where users can see items at affordable prices that would not otherwise be made ‘kanker’ as a short of kantong kering in Indonesia.', 'Approve', '2023-12-12', '2023-09-14', 'https://belanja.yuk.com', '2.jpg', '', 3, 3, 3),
(3, 'Thesis Exp', 'Thesis Explorer is a cutting-edge desktop application designed to revolutionize the way researchers and students explore and analyze academic theses. This innovative system utilizes advanced algorithms and natural language processing techniques to provide users with a comprehensive platform for discovering, organizing, and extracting valuable insights from a vast collection of theses.', 'Pending', '2020-04-11', '2021-01-28', 'https:/thesis.explorer.com', '3.jpg', 'https://thesisiyou.com', 2, 3, 2),
(4, 'Dis Cysec', 'Dis Cysec is a website that can make it easier for users to learn about disaster recovery in cyber security', 'Approve', '2022-02-23', '2022-04-25', 'https:/dis.cysec.com', '4.jpg', '', 1, 3, 1),
(5, 'Uilapedia', 'Uilapedia is a website that offer a wide range of high-quality preloved tech. Sellers can easily list their items, while buyers can browse and purchase securely. ', 'Approve', '2022-08-11', '2023-05-27', 'https:/uilapedia.com', '5.jpg', '', 3, 3, 3),
(6, 'Go Train', 'Step into a world where transportation is reimagined, where cutting-edge technologies and visionary ideas converge to shape the way we move. Welcome to our captivating display of transportation innovation, where we invite you to witness the future unfold before your eyes.', 'Pending', '2021-09-01', '2022-10-18', 'https:/go.train.com', '6.jpg', '', 3, 3, 3),
(7, 'Book: Open', 'Open Your Heart is a collaborative work between lecturers and students who took the idea from Armadas song entitled Open Your Heart with the song lyrics: I have done various things for your life until I sacrificed my life. Open your heart, open it a little for me so that I can have you. ', 'Approve', '2023-01-12', '2023-04-30', 'https:/open.your.heart.com', '7.jpg', '', 4, 3, 4),
(8, 'GanesHealth', 'GanesHealth is an innovation that aims to provide health services for general students at Ganesha University of Education', 'Approve', '2022-07-03', '2023-02-28', 'https:/ganeshealth.com', '8.jpg', '', 4, 2, 2),
(9, 'Perangkat IoT untuk Monitoring Kesehatan Pekerja', 'IoT Devices for Monitoring Worker Health\r\nDevelopment of IoT devices that monitor the health and safety of workers in the work environment, helping to reduce the risk of injury and illness.\r\n', 'Reject', '2022-11-11', '2023-04-29', 'https:/Perangkat IoT untuk Monitoring Kesehatan Pe', '9.jpg', '', 2, 3, 2),
(10, 'Technology Infrastructure Analysis (Zoom)\r\n', 'Zoom could analyze its technology infrastructure, including server capacity, network performance, and scalability. This analysis helps Zoom ensure a seamless user experience, identify potential bottlenecks, and plan for future growth.', 'Approve', '2022-10-10', '2023-01-08', 'https:/analysis.zoom.com', '10.jpg', NULL, 2, 3, 4),
(11, 'Sistem Analitik Prediktif', 'Implementation of a predictive analytics system that utilizes artificial intelligence to analyze sales data and forecast future market trends.\r\n', 'Approve', '2022-10-05', '2023-02-14', 'https:/Sistem Analitik Prediktif.com', '11.jpg', NULL, 3, 3, 3),
(12, 'Platform Kolaborasi Online', 'Launch of an online collaboration platform that allows internal and external teams to work together on projects efficiently, regardless of physical location.', 'Pending', '2023-04-12', '2023-08-15', 'https:/Platform Kolaboras.com', '12.jpg', NULL, 2, 3, 1),
(13, 'Keamanan Jaringan yang Ditingkatkan', 'Improved company network security systems by installing advanced firewalls and stronger intrusion detection systems to protect sensitive data.', 'Approve', '2023-02-05', '2023-08-17', 'https:/Keamanan Jaringan yang Ditingkatkan.com', '13.jpg', NULL, 1, 3, 4),
(14, 'Aplikasi Pintar untuk Manajemen Proyek', 'Launch of a project management application that uses artificial intelligence to optimize schedules, resources and real-time project monitoring.', 'Approve', '2023-04-11', '2023-10-28', 'https:/Aplikasi Pintar untuk Manajemen Proyek.com', '14.jpg', NULL, 2, 3, 3),
(15, 'Lemari Buku', 'Lemari Buku is an innovation that aims to facilitate a digital reading space to increase users reading interest.', 'Reject', '2023-02-17', '2022-08-29', 'https:/lemari.buku.com', '15.jpg, 15a.jpg, 15b.jpg', NULL, 2, 3, 3),
(16, 'HIPC (Hidup Ini Penuh Cobaan) Katalog Struggle Mahasiswa SIFORS UNDIKSHA', 'Hidup Ini Penuh Cobaan is a an information system that contains all the stories and complaints of UNDIKSHA students while studying at this beloved campus, to improve the mental health of each student in the future for a brighter and healthier UNDIKSHA.', 'Approve', '2023-04-19', '2022-08-28', 'https://hipc.undiksha.ac.id', '16.jpg', NULL, 2, 1, 1),
(17, 'Integrasi Sistem Enterprise', 'Integration of all the companys enterprise systems into one single platform to increase operational efficiency and reduce redundancy.', 'Approve', '2023-06-23', '2022-09-30', 'https:/Integrasi Sistem Enterprise.com', '17.jpg', NULL, 3, 2, 2),
(18, 'Algoritma Pencarian Cepat', 'Development of new search algorithms that can increase speed and accuracy in the data search process in company databases.', 'Reject', '2023-07-20', '2023-02-15', 'https:/Algoritma Pencarian Cepat.com', '18.jpg', NULL, 3, 3, 1),
(19, 'Sistem Informasi Keuangan Terintegrasi', 'Integration of all company financial information systems into one platform to facilitate monitoring, reporting and financial decision making.', 'Approve', '2023-01-02', '2023-07-17', 'https:/Sistem Informasi Keuangan Terintegrasi.com', '19.jpg', NULL, 4, 3, 2),
(20, 'Layanan Cloud Computing Kustom', 'Development of custom cloud computing services to meet corporate computing and data storage needs more efficiently.', 'Approve', '2023-04-01', '2023-07-25', 'https:/Layanan Cloud Computing Kustom.com', '20.jpg, 20a.jpg, 20b.jpg', NULL, 3, 3, 4),
(21, 'Keamanan IoT yang Terintegrasi', 'Development of integrated security for Internet of Things (IoT) devices that protect data and systems from potential cyber threats.', 'Approve', '2023-04-12', '2023-08-06', 'https:/Keamanan IoT yang Terintegrasi.com', '21.jpg', NULL, 1, 3, 4),
(22, 'Sistem Deteksi Serangan Lanjutan (Advanced Threat Detection)', 'Implement an attack detection system that uses behavioral analysis and artificial intelligence to identify more sophisticated cyberattacks and respond to them quickly.', 'Approve', '2023-02-03', '2023-04-18', 'https:/Sistem Deteksi Serangan Lanjutan .com', '22.jpg', NULL, 1, 3, 4),
(23, 'Balinese Aksara to English Translator', 'Balinese Aksara to English Translator is an innovation that aims to introduce Balinese script to the international stage so that people who go on holiday to Bali can easily translate Balinese script.', 'Approve', '2022-11-28', '2022-07-18', 'https:/balinese.aksara.to.english.translator.com', '23.jpg', NULL, 2, 3, 2),
(24, 'Analisis Risiko Keamanan Berbasis AI', 'Development of a security risk analysis system that utilizes artificial intelligence to identify potential risks and provide appropriate action recommendations.', 'Approve', '2023-04-05', '2023-09-19', 'https:/Analisis Risiko Keamanan Berbasis AI.com', '24.jpg', NULL, 1, 3, 4),
(25, 'Prioritize Yourself Over Other Things', 'Prioritize Yourself Over Other Things is an innovation that provides counseling services with a variety of experts who are combined to help you resolve a tangled thread.', 'Approve', '2023-01-07', '2021-05-29', 'https:/prioritize.yourself.over.other.things.com', '25.jpg', NULL, 3, 3, 1),
(26, 'Soulmelted', 'Do your friends often tease you because you are the only one among those who are dating? Dont worry, Soulmelted provides various types of choices that you can match to your preferences, just by swiping to the right you will get a girlfriend! of course at the same price, what are you waiting for? show off your girlfriend to your friends.', 'Approve', '2023-09-11', '2022-07-19', 'https:/soulmelted.com', '26.jpg', NULL, 4, 3, 1),
(27, 'Personal Colour Testing', 'Confused about which color suits your skin? We will help you find the color that will make your face brighter.', 'Approve', '2022-02-13', '2021-10-09', 'https:/personal.colour.testing.com', '27.jpg', NULL, 2, 3, 3),
(28, 'Love Me-ter', 'Calculate the accuracy and compatibility between you and your partner via Love Me-ter! Just write your name and your partners name and you will immediately know the results.', 'Approve', '2023-07-23', '2022-02-18', 'https:/love.meter.com', '28.jpg', NULL, 4, 3, 1),
(30, 'AMORA\r\nUI/UX Design Competition: Food and Beverage Edition', 'In order To open a new restaurant in the city center, AMORA is holding a UI/UX Design competition with a food and beverage theme which can be participated by the general public aged 18-25 years. The Ayo Dong Bantai Kami team won second place after presenting a topic that explored typical Yogyakarta regional food modified with elements of modernity without eliminating the existing traditional characteristics.', 'Approve', '2022-01-28', '2021-10-06', 'https:/ui.ux.f&b.com', '30.jpg', NULL, 4, 3, 4),
(31, 'FESTRA Business Plan Competition.', 'FESTRA also known as Festival Bahasa dan Sastra who held a business plan competition to hone students abilities to become more creative by developing ideas that have been given in accordance with the provisions listed. The Widih Kmie GG Bngitz team, which came from Information Systems Study Program students with four members, won first place with the theme Exploring Resources as a Movement in Striving for Sustainable Development Goals 2030.', 'Approve', '2023-07-23', '2022-12-20', 'https:/festra.buss.plan.com', '31.jpg', NULL, 3, 3, 4),
(32, 'TWEAK#8 Essay Competition ', 'BEM FTK holds an annual event to celebrate the faculty\'s birthday which opens with various competitions, the event is called Together We Stand for FTK. A student named Ida Ayu Gede Putri Audrey Aurethashafa Pramudya Winayaka won a silver medal for an essay with the theme: Just because I\'m stupid, am I not worthy of aiming as high as the sky?', 'Approve', '2023-09-13', '2023-05-23', 'https:/tweak.delapan.bem.ftk.2023.com', '32.jpg', NULL, 4, 3, 4),
(33, 'Cara Agar Tidak Mudah Marah', 'Cara Agar Tidak Mudah Marah is a collaborative masterpiece in the form of a book found in the public library of the Ganesha University of Education. The book raises topics originating from local research which found that the majority of people in the campus environment tend to have high temperament.', 'Approve', '2021-11-15', '2020-01-05', 'https:/cara.agar.tidak.mudah.marah.com', '33.jpg', NULL, 4, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `innovpending`
--

CREATE TABLE `innovpending` (
  `IDInnov` int(10) NOT NULL,
  `nameInnov` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `IDType` int(10) NOT NULL,
  `NameType` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`IDType`, `NameType`) VALUES
(1, 'Website'),
(2, 'Desktop'),
(3, 'MobileApp'),
(4, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `IDUser` varchar(10) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Role` enum('Student','Lecturer') NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `UserPass` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`IDUser`, `Username`, `Role`, `Email`, `Phone`, `UserPass`) VALUES
('0004012503', 'Scaramouche', 'Lecturer', 'scaramouche@undiksha.ac.id', '082192101102', 'scarasouche'),
('0004125053', 'Arshello Malik', 'Lecturer', 'arshello@undiksha.ac.id', '085810725286', 'taliopsional'),
('0004125076', 'Anarghya Mikael', 'Lecturer', 'anarghya@undiksha.ac.id', '082162964288', 'gakwarastonn'),
('0004125099', 'Kaito Wisesa', 'Lecturer', 'kaito@undiksha.ac.id', '082144007249', 'rafaeladoktersejati'),
('0004125412', 'Reskala Auriga', 'Lecturer', 'reskala.auriga@undiksha.ac.id', '081239079834', 'qieiulovemartis'),
('1615091029', 'Princess Aurora Rapunzel Cinderella Simanjuntak', 'Student', 'princess.aurora@student.undiksha.ac.id', '089382910221', 'snowwhite'),
('1615091030', 'Anak Agung Gede Agung Abi Berlian Chaveiler Sapphire Kusumawangsa', 'Student', 'anak.agung.gede.agung.abi.berlian@student.undiksha.ac.id', '082106291033', 'pearlmilktea'),
('1715091037', 'Melody Nurramadhani Laksani', 'Student', 'melody@student.undiksha.ac.id', '082144409421', 'dirimumelody'),
('1815091001', 'Dewi Handayani', 'Student', 'dewi.handayani@student.undiksha.ac.id', '082239033190', 'mamazumba'),
('1815091002', 'Kariyani Sukerti', 'Student', 'kariyani.sukerti@student.undiksha.ac.id', '088137529627', 'sayangibunda'),
('1815091003', 'Hidup Ini Penuh Cobaan', 'Student', 'hidup.ini@student.undiksha.ac.id', '08192291031', 'maintrampolin'),
('1815091005', 'Afrilia Fondra Curniasari', 'Student', 'afrilia.fondra@student.undiksha.ac.id', '085862823272', 'mamibanana'),
('1815091006', 'Emmaleigh Haley Stewardess Sangkuriang', 'Student', 'emmaleigh@student.undiksha.ac.id', '082144409960', 'karenlove'),
('1815091007', 'Cangkir Setengah Penuh Penanda Esok Cerah Mentari', 'Student', 'cangkir@student.undiksha.ac.id', '087612920123', 'harapandoang'),
('1815091028', 'Rayuan Pulau Kelapa', 'Student', 'rayuan@student.undiksha.ac.id', '089139193232', 'ismailmarzuki'),
('1815091065', 'Matheo Mangkusadewo', 'Student', 'matheo@student.undiksha.ac.id', '082235446782', 'makanapaharini'),
('1815091091', 'Rangga Dewamoela', 'Student', 'rangga.dewamoela@student.undiksha.ac.id', '083929030332', 'smashnomor1'),
('1815091099', 'Renata Adhiyaksa', 'Student', 'renata.adhiyaksa@student.undiksha.ac.id', '081338545292', 'lapsedfaith'),
('1915091002', 'Ida Ayu Gede Putri Audrey Aurethashafa Pramudya Winayaka', 'Student', 'ida.ayu.gede.putri.audrey@student.undiksha.ac.id', '089201334201', 'shafaretha'),
('1915091003', 'Tangkuban Perahu Fans Tajikistan', 'Student', 'tangkuban@student.undiksha.ac.id', '08911022131', 'sangkur1ang'),
('1915091012', 'Raden Veda Suta Diningrat', 'Student', 'raden.veda@student.undiksha.ac.id', '081238867357', 'gagangpintu'),
('1915091022', 'Jang Anmulia Wonyoung', 'Student', 'jang.anmulia@student.undiksha.ac.id', '083912101112', 'afterlike'),
('1915091041', 'Cangkir Kosong Tanpa Kepastian', 'Student', 'cangkir.kosong@student.undiksha.ac.id', '088219201322', 'harapanpupus'),
('1915091072', 'Elsa Frozen', 'Student', 'elsa.frozen@student.undiksha.ac.id', '081329231101', 'bikinsnowman'),
('2015091001', 'Tut Wuri Dj Mahesa', 'Student', 'tut.wuri.handayani@student.undiksha.ac.id', '08102020132', 'naxpaskib'),
('2015091011', 'Le Sserafim', 'Student', 'le.sserafim@student.undiksha.ac.id', '08312239191', 'sakuramybeloved'),
('2015091016', 'Aeri Uchinaga', 'Student', 'aeri@student.undiksha.ac.id', '082192110231', 'memberaespa'),
('2015091022', 'Tjokorda Yohanes Gautama', 'Student', 'tjokorda.yohanes@student.undiksha.ac.id', '081232579574', 'chiakicikiwir'),
('2015091033', 'Anmulia Salatiga Semaradhana', 'Student', 'anmulia.salatiga@student.undiksha.ac.id', '089221329301', 'rizqieramadhana'),
('2015091060', 'Jeong Prameswari Jaehyun', 'Student', 'jeong.prameswari@student.undiksha.ac.id', '081920123341', 'jaehyunoppa'),
('2015091067', 'Miles Kano Karnadi', 'Student', 'miles.kano@student.undiksha.ac.id', '088523994523', 'donat5k'),
('2015091069', 'Kalingga Adikara', 'Student', 'kalingga.adikara@student.undiksha.ac.id', '081336545482', 'spensupremacy'),
('2015091099', 'Iqbaal Ramadhan', 'Student', 'iqbaal@student.undiksha.ac.id', '081919392123', 'coboyjuniorea'),
('2016201023', 'Naruto Uzumaki', 'Student', 'naruto.uzumaki@student.undiksha.ac.id', '08193230121', 'sasukeuchiha'),
('2115091002', 'Jeon Jungkook', 'Student', 'jungkook@student.undiksha.ac.id', '082144400892', 'bangtanot7'),
('2115091010', 'Kurir Rempeyek', 'Student', 'namessayangchiaki@student.undiksa.ac.id', '082237450591', 'akukaya69'),
('2115091024', 'Names Twice Ambassador Samsung Galaxy Note Besik', 'Student', 'names.twice@student.undiksha.ac.id', '089102012303', 'whatisheart'),
('2115091027', 'Kim Melianti Taehyung', 'Student', 'kim.melianti@student.undiksha.ac.id', '085019210113', 'taehyungoppa'),
('2115091033', 'Haikal Naraya', 'Student', 'haikal.naraya@student.undiksha.ac.id', '08983158579', 'kipascosmos'),
('2115091055', 'Arjuna Sastradinata', 'Student', 'arjuna.sastradinata@student.undiksha.ac.id', '087249672134', 'bingungbanget'),
('2115091073', 'Giring Garong', 'Student', 'giring@student.undiksha.ac.id', '083120123123', 'laskarpelangi'),
('2115091099', 'Samurai Ninja Mitsubishi', 'Student', 'samurai@student.undiksha.ac.id', '082921320211', 'ruroun1Kenshin'),
('2215091010', 'Natama Demure ', 'Student', 'natama@student.undiksha.ac.id', '085810883215', 'escoklat'),
('2215091018', 'Ginandra Nareswara', 'Student', 'ginandra.nareswara@student.undiksha.ac.id', '087257923476', 'aresjawir'),
('2215091054', 'Lisa Blackpink ', 'Student', 'lisa.blackpink@student.undiksha.ac.id', '085201133132', 'killthisheart'),
('2215091063', 'Erica Abimanyu', 'Student', 'erica.abimanyu@student.undiksha.ac.id', '082144019213', 'microsoftword'),
('2215091066', 'Seto Mulyadi', 'Student', 'seto.mulyadi@student.undiksha.ac.id', '08291289109', 'pecintabalita'),
('2315091002', 'Desta Maheswara', 'Student', 'desta.maheswara@student.undiksha.ac.id', '08279528326', 'udengtabanan'),
('2315091005', 'Septiasa Eka Mahayana', 'Student', 'septiasa@student.undiksha.ac.id', '08384585247', 'satudua3'),
('2315091010', 'Dian Anggraini', 'Student', 'dian.anggraini@student.undiksha.ac.id', '08315207931', 'cecanspensa'),
('2315091020', 'Arya Bumi Pancawikrama', 'Student', 'arya.bumi@student.undiksha.ac.id', '082147413799', 'jupiter29bulan'),
('2315091022', 'Adinda Melatie', 'Student', 'adinda.melatie@student.undiksha.ac.id', '08896348168', 'mawarmerah'),
('2315091042', 'Anak Agung Muhammad Hezekiel Primantara ', 'Student', 'anak.agung.muhammad@student.undiksha.ac.id', '08291929101', 'yameteplease'),
('2315091070', 'Kayudha Arya Janitra', 'Student', 'kayudha.arya@student.undksha.ac.id', '087765653522', 'kayucoklat'),
('2315091072', 'Cangkir Penuh Harapan Habis Beli Google Pixel', 'Student', 'cangkir.penuh@student.undiksha.ac.id', '089110212312', 'harapanpalsu');

-- --------------------------------------------------------

--
-- Table structure for table `userinnov`
--

CREATE TABLE `userinnov` (
  `IDInnov` int(10) NOT NULL,
  `IDUser` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinnov`
--

INSERT INTO `userinnov` (`IDInnov`, `IDUser`) VALUES
(1, '0004125053'),
(1, '1815091003'),
(1, '2015091033'),
(1, '2115091002'),
(1, '2115091011'),
(2, '0004012503'),
(2, '0004125076'),
(2, '2015091067'),
(2, '2115091055'),
(2, '2215091018'),
(2, '2315091042'),
(3, '0004125053'),
(3, '0004125076'),
(3, '1815091065'),
(3, '2315091070'),
(4, '0004125053'),
(4, '0004125412'),
(4, '2115091010'),
(5, '0004125099'),
(5, '1915091012'),
(5, '2015091022'),
(5, '2015091067'),
(5, '2016201023'),
(5, '2115091033'),
(5, '2115091055'),
(5, '2215091010'),
(6, '0004125412'),
(6, '1815091001'),
(6, '1815091002'),
(6, '1815091003'),
(7, '0004012503'),
(7, '0004125099'),
(7, '2315091002'),
(7, '2315091005'),
(7, '2315091010'),
(7, '2315091020'),
(7, '2315091022'),
(8, '0004125412'),
(8, '2016201023'),
(9, '0004125076'),
(9, '2015091011'),
(9, '2215091066'),
(10, '0004125099'),
(10, '1715091037'),
(10, '1815091028'),
(10, '1815091091'),
(10, '1815091099'),
(11, '0004012503'),
(11, '0004125076'),
(11, '0004125412'),
(11, '1615091029'),
(11, '1915091072'),
(11, '2015091099'),
(11, '2115091099'),
(12, '0004125076'),
(12, '1915091022'),
(12, '2015091016'),
(12, '2115091027'),
(13, '0004125053'),
(13, '1615091030'),
(13, '1915091002'),
(13, '2015091060'),
(13, '2015091069'),
(14, '0004125412'),
(14, '1815091007'),
(14, '1915091041'),
(14, '2115091073'),
(14, '2215091063'),
(14, '2315091072'),
(15, '0004125076'),
(15, '2015091001'),
(15, '2115091024'),
(15, '2215091054'),
(16, '0004125099'),
(16, '1915091003'),
(17, '0004012503'),
(17, '1815091006'),
(18, '0004125076'),
(18, '1815091002'),
(18, '1815091091'),
(19, '0004125053'),
(19, '0004125076'),
(19, '0004125099'),
(19, '2015091001'),
(19, '2015091067'),
(19, '2016201023'),
(20, '0004012503'),
(20, '2115091024'),
(20, '2215091010'),
(20, '2215091033'),
(20, '2315091005'),
(21, '0004125053'),
(21, '0004125412'),
(21, '1715091037'),
(21, '1915091022'),
(21, '2015091033'),
(21, '2015091099'),
(22, '0004125412'),
(22, '2115091010'),
(22, '2215091018'),
(22, '2215091063'),
(23, '0004125053'),
(23, '0004125099'),
(23, '2115091055'),
(24, '0004012503'),
(24, '2115091024'),
(24, '2115091099'),
(24, '2315091020'),
(24, '2315091042'),
(24, '2315091070'),
(24, '2315091072'),
(25, '0004125412'),
(25, '2015091069'),
(25, '2315091002'),
(26, '0004125076'),
(26, '1615091029'),
(26, '1615091030'),
(26, '1815091099'),
(26, '2015091016'),
(27, '0004012503'),
(27, '2015091022'),
(27, '2015091060'),
(27, '2115091073'),
(28, '0004125412'),
(28, '1915091012'),
(29, '0004125099'),
(29, '2115091010'),
(29, '2215091010'),
(29, '2315091010'),
(30, '0004125053'),
(30, '1815091001'),
(30, '1815091002'),
(30, '1815091005'),
(30, '1815091028'),
(30, '1815091065'),
(30, '1815091099'),
(31, '0004125076'),
(31, '2115091033'),
(31, '2115091055'),
(31, '2215091018'),
(31, '2315091002'),
(32, '0004125053'),
(32, '1915091002'),
(33, '0004125412'),
(33, '2015091011'),
(33, '2015091060'),
(33, '2115091011'),
(71, ''),
(73, ''),
(75, '0004125099'),
(75, '2215091054'),
(77, '0004125099'),
(77, '2215091054'),
(79, '0004125099'),
(79, '2115091024'),
(81, '');

-- --------------------------------------------------------

--
-- Table structure for table `validation`
--

CREATE TABLE `validation` (
  `IDValid` int(10) NOT NULL,
  `IDInnov` int(10) NOT NULL,
  `Decision` enum('Approve','Reject') NOT NULL,
  `Note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `validation`
--

INSERT INTO `validation` (`IDValid`, `IDInnov`, `Decision`, `Note`) VALUES
(1, 1, 'Approve', ''),
(2, 2, 'Approve', ''),
(4, 4, 'Approve', ''),
(5, 5, 'Approve', ''),
(7, 7, 'Approve', ''),
(8, 8, 'Approve', ''),
(9, 9, 'Reject', 'Uploaded photos does not seem to match the invention given'),
(10, 10, 'Approve', ''),
(11, 11, 'Approve', ''),
(13, 13, 'Approve', ''),
(14, 14, 'Approve', ''),
(15, 15, 'Reject', 'Description contains SARA or other offending materials'),
(16, 16, 'Approve', ''),
(17, 17, 'Approve', ''),
(18, 18, 'Reject', 'A lecturer is wrongly labeled as a student'),
(19, 19, 'Approve', ''),
(20, 20, 'Approve', ''),
(21, 21, 'Approve', ''),
(22, 22, 'Approve', ''),
(23, 23, 'Approve', ''),
(24, 24, 'Approve', ''),
(25, 25, 'Approve', ''),
(26, 26, 'Approve', ''),
(27, 27, 'Approve', ''),
(28, 28, 'Approve', ''),
(29, 29, 'Approve', ''),
(30, 30, 'Approve', ''),
(31, 31, 'Approve', ''),
(32, 32, 'Approve', ''),
(33, 33, 'Approve', '');

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
-- Indexes for table `innovdata`
--
ALTER TABLE `innovdata`
  ADD PRIMARY KEY (`IDInnov`);

--
-- Indexes for table `innovpending`
--
ALTER TABLE `innovpending`
  ADD PRIMARY KEY (`IDInnov`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`IDType`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`IDUser`);

--
-- Indexes for table `userinnov`
--
ALTER TABLE `userinnov`
  ADD UNIQUE KEY `CreatorID` (`IDInnov`,`IDUser`);

--
-- Indexes for table `validation`
--
ALTER TABLE `validation`
  ADD PRIMARY KEY (`IDValid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `innovdata`
--
ALTER TABLE `innovdata`
  MODIFY `IDInnov` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `innovpending`
--
ALTER TABLE `innovpending`
  MODIFY `IDInnov` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userinnov`
--
ALTER TABLE `userinnov`
  MODIFY `IDInnov` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `validation`
--
ALTER TABLE `validation`
  MODIFY `IDValid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
