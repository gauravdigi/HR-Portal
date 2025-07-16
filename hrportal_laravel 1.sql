-- Adminer 5.3.0 MySQL 5.5.45 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `candidates`;
CREATE TABLE `candidates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `alternate_phone_number` varchar(20) DEFAULT NULL,
  `total_experience_years` int(10) unsigned DEFAULT '0',
  `total_experience_months` int(10) unsigned DEFAULT '0',
  `current_company` varchar(255) DEFAULT NULL,
  `ctc_per_month` decimal(12,2) DEFAULT '0.00',
  `ectc_per_month` decimal(12,2) DEFAULT '0.00',
  `is_salary_negotiable` tinyint(1) DEFAULT '0',
  `salary_negotiable` varchar(255) DEFAULT '0.00',
  `notice_period_days` int(10) unsigned DEFAULT '0',
  `is_notice_negotiable` tinyint(1) DEFAULT '0',
  `notice_negotiable_days` int(10) unsigned DEFAULT '0',
  `linkedin_url` varchar(255) DEFAULT NULL,
  `candidate_source` varchar(100) DEFAULT NULL,
  `current_designation` varchar(255) DEFAULT NULL,
  `applied_designation` varchar(255) DEFAULT NULL,
  `stream` varchar(100) DEFAULT NULL,
  `remark` text,
  `reason` text,
  `resume_path` varchar(255) DEFAULT NULL,
  `skills` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `candidates` (`id`, `is_deleted`, `first_name`, `last_name`, `email`, `phone_number`, `alternate_phone_number`, `total_experience_years`, `total_experience_months`, `current_company`, `ctc_per_month`, `ectc_per_month`, `is_salary_negotiable`, `salary_negotiable`, `notice_period_days`, `is_notice_negotiable`, `notice_negotiable_days`, `linkedin_url`, `candidate_source`, `current_designation`, `applied_designation`, `stream`, `remark`, `reason`, `resume_path`, `skills`, `created_at`, `updated_at`) VALUES
(8,	0,	'Ritika',	'Mehta',	'Ritikamehta2504@gmail.com',	'8572836494',	NULL,	NULL,	NULL,	NULL,	8000.00,	15000.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	NULL,	'Junior',	'HR',	NULL,	NULL,	'resumes/qyNQAeRCk9xndYcHhJ2sOYGp5Xv7h3MuvBI5dfZ7.pdf',	NULL,	'2025-07-08 17:19:56',	'2025-07-10 14:06:21'),
(9,	0,	'Priya',	'Pal',	'palp7117@gmail.com',	'8791302480',	NULL,	3,	4,	'Vanced Solutions Pvt. Ltd',	29000.00,	50000.00,	1,	'47000',	30,	0,	NULL,	'https://www.linkedin.com/in/priya-developer/',	'LinkedIn',	'Junior',	'Junior',	'.NET',	NULL,	NULL,	'resumes/priya_pal_resume.pdf',	'\"[{\\\"name\\\":\\\"9\\\",\\\"exp_years\\\":\\\"3\\\",\\\"exp_months\\\":\\\"4\\\"}]\"',	'2025-07-10 14:04:52',	'2025-07-10 14:04:52'),
(10,	0,	'Gurpreet',	'Singh',	'gurpreetsingh0297@gmail.com',	'9915646566',	NULL,	3,	NULL,	'CS Soft Solutions PVT. LTD.',	23333.00,	37500.00,	1,	'33333',	30,	0,	NULL,	'https://www.linkedin.com/in/gurpreet-singh-83a4b0b0/',	'LinkedIn',	'Junior',	'Junior',	'.NET',	NULL,	NULL,	'resumes/gurpreet_singh_resume.pdf',	'\"[{\\\"name\\\":\\\"9\\\",\\\"exp_years\\\":\\\"3\\\",\\\"exp_months\\\":null}]\"',	'2025-07-10 14:58:02',	'2025-07-10 14:58:02'),
(11,	0,	'Brijesh',	'Jamloki',	'brijesh1084@gmail.com',	'9149034923',	NULL,	4,	NULL,	'Bytecode Technologies',	62500.00,	91666.00,	1,	'87500',	30,	0,	NULL,	'https://www.linkedin.com/in/brijesh-jamloki-86a9211a4/',	'LinkedIn',	'Junior',	'Junior',	'.NET',	NULL,	NULL,	'resumes/brijesh_jamloki_resume.pdf',	'[{\"name\":\"7\",\"exp_years\":\"1\",\"exp_months\":null},{\"name\":\"9\",\"exp_years\":null,\"exp_months\":\"6\"}]',	'2025-07-10 15:02:37',	'2025-07-10 16:42:58'),
(12,	0,	'Abhishek',	'Sharma',	'abhishek001.as19@gmail.com',	'9816125348',	NULL,	5,	NULL,	'CS Soft Solutions Pvt. Ltd.',	83333.00,	125000.00,	1,	'108333',	0,	0,	NULL,	'https://www.linkedin.com/in/abhishek-sharma-092539bb/',	'LinkedIn',	'Senior',	'Senior',	'.NET',	NULL,	NULL,	'resumes/abhishek_sharma_resume.docx',	'[{\"name\":\"9\",\"exp_years\":\"1\",\"exp_months\":\"0\"},{\"name\":\"8\",\"exp_years\":\"1\",\"exp_months\":\"2\"}]',	'2025-07-10 15:08:17',	'2025-07-11 20:12:40'),
(13,	0,	'Harmeet',	'Singh',	'harmeet.rksh@gmail.com',	'8445999499',	NULL,	6,	NULL,	'Zapbuild Technologies Pvt. Ltd.',	40000.00,	50000.00,	0,	NULL,	60,	0,	NULL,	'https://www.linkedin.com/in/myselfharmeetsingh/',	'LinkedIn',	'Senior',	'Senior',	'Sales',	NULL,	NULL,	'resumes/harmeet_singh_resume.pdf',	'\"[{\\\"name\\\":\\\"212\\\",\\\"exp_years\\\":\\\"6\\\",\\\"exp_months\\\":null}]\"',	'2025-07-10 16:40:51',	'2025-07-10 16:40:51'),
(14,	1,	'kalodj',	'hdeuh',	'jkdnjan@gmail.com',	'5724582790',	NULL,	3,	NULL,	'fbfcajbcfja',	50000.00,	70000.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Junior',	'Junior',	'.NET',	NULL,	NULL,	NULL,	'\"[{\\\"name\\\":\\\"9\\\",\\\"exp_years\\\":\\\"3\\\",\\\"exp_months\\\":null},{\\\"name\\\":\\\"8\\\",\\\"exp_years\\\":\\\"3\\\",\\\"exp_months\\\":null}]\"',	'2025-07-10 17:48:22',	'2025-07-10 17:49:03'),
(15,	0,	'Pankaj',	'Chandel',	'pankajchandel212@gmail.com',	'8278797464',	NULL,	3,	3,	'BeyondRoot Technologies',	75000.00,	100000.00,	1,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Senior',	'Senior',	'.NET',	'Exceed Budget',	NULL,	'resumes/pankaj_chandel_resume.pdf',	'\"[{\\\"name\\\":\\\"9\\\",\\\"exp_years\\\":\\\"3\\\",\\\"exp_months\\\":null},{\\\"name\\\":\\\"8\\\",\\\"exp_years\\\":\\\"3\\\",\\\"exp_months\\\":null}]\"',	'2025-07-10 17:48:22',	'2025-07-10 17:48:22'),
(16,	0,	'Kapil',	'Gaur',	'jogikapil476@gmail.com',	'8813056506',	NULL,	NULL,	NULL,	NULL,	NULL,	12000.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Trainee',	'Junior',	'Designer',	'No Experience in Figma',	NULL,	'resumes/kapil_gaur_resume.pdf',	'\"[{\\\"name\\\":\\\"41\\\",\\\"exp_years\\\":\\\"1\\\",\\\"exp_months\\\":\\\"0\\\"},{\\\"name\\\":\\\"42\\\",\\\"exp_years\\\":\\\"1\\\",\\\"exp_months\\\":\\\"0\\\"}]\"',	'2025-07-10 18:05:18',	'2025-07-10 18:05:18'),
(17,	0,	'Ankita',	'Singh',	'ankitasingh11954@gmail.com',	'8273355127',	NULL,	1,	6,	'Rubico IT Pvt. Ltd.',	30000.00,	40000.00,	1,	NULL,	30,	0,	NULL,	'https://www.linkedin.com/in/ankita-singh-2b142722a/?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app',	'LinkedIn',	'Junior',	'Junior',	'Others',	NULL,	NULL,	NULL,	'\"[{\\\"name\\\":\\\"157\\\",\\\"exp_years\\\":\\\"1\\\",\\\"exp_months\\\":\\\"6\\\"}]\"',	'2025-07-10 18:18:14',	'2025-07-10 18:18:14'),
(18,	0,	'Abhishek',	'Sharma',	'avi9805882744@gmail.com',	'9198058827',	NULL,	2,	NULL,	'DuckTale IT Service',	22000.00,	50000.00,	0,	NULL,	30,	0,	NULL,	'https://www.linkedin.com/in/abhishek-sharma-b5461a1a4/',	'LinkedIn',	'Junior',	'Junior',	'.NET',	NULL,	NULL,	'resumes/abhishek_sharma_resume.pdf',	'\"[{\\\"name\\\":\\\"9\\\",\\\"exp_years\\\":\\\"2\\\",\\\"exp_months\\\":null},{\\\"name\\\":\\\"8\\\",\\\"exp_years\\\":\\\"2\\\",\\\"exp_months\\\":null}]\"',	'2025-07-10 19:34:18',	'2025-07-10 19:34:18'),
(19,	0,	'Roshni',	'rana',	'roshnirana167@gmail.com',	'8294913377',	NULL,	1,	6,	'ITECHNOLABS',	22000.00,	33000.00,	1,	'30800',	20,	0,	NULL,	'https://www.linkedin.com/in/roshni-rana-949588232/',	'LinkedIn',	'Junior',	'Junior',	'Others',	NULL,	NULL,	'resumes/roshni_rana_resume.pdf',	'\"[]\"',	'2025-07-10 19:50:15',	'2025-07-10 19:50:15'),
(20,	0,	'Ayush Shankar',	'Rajput',	'ayush.shankarrajput@gmail.com',	'9068989306',	NULL,	1,	10,	'QServices IT Solutions Inc.',	23500.00,	37500.00,	1,	NULL,	0,	0,	NULL,	'https://www.linkedin.com/in/ayush-shankar-rajput-88a0a5187/',	'LinkedIn',	'Junior',	'Junior',	'.NET',	NULL,	NULL,	'resumes/ayush_shankar_rajput_resume.pdf',	'\"[{\\\"name\\\":\\\"9\\\",\\\"exp_years\\\":\\\"1\\\",\\\"exp_months\\\":\\\"10\\\"},{\\\"name\\\":\\\"8\\\",\\\"exp_years\\\":\\\"1\\\",\\\"exp_months\\\":\\\"10\\\"}]\"',	'2025-07-10 20:01:50',	'2025-07-10 20:01:50'),
(21,	0,	'Mumtaz',	'Ahmad',	'ahmadmumtazm12345@gmail.com',	'8303667116',	NULL,	3,	6,	'Kaspro Software Solution Pvt Ltd',	33333.00,	50000.00,	0,	NULL,	0,	0,	NULL,	'https://www.linkedin.com/in/mumtaz-ahmad-3151a6243/',	'LinkedIn',	'Junior',	'Junior',	'.NET',	NULL,	NULL,	'resumes/mumtaz_ahmad_resume.pdf',	'\"[{\\\"name\\\":\\\"9\\\",\\\"exp_years\\\":\\\"3\\\",\\\"exp_months\\\":\\\"6\\\"},{\\\"name\\\":\\\"8\\\",\\\"exp_years\\\":\\\"3\\\",\\\"exp_months\\\":\\\"6\\\"},{\\\"name\\\":\\\"1\\\",\\\"exp_years\\\":\\\"1\\\",\\\"exp_months\\\":null}]\"',	'2025-07-11 12:07:22',	'2025-07-11 12:07:22'),
(22,	0,	'Mumtaz',	'Ahmad',	'ahmadmumtazm12345@gmail.com',	'8303667116',	NULL,	3,	6,	'Kaspro Software Solution Pvt Ltd',	33333.00,	50000.00,	0,	NULL,	0,	0,	NULL,	'https://www.linkedin.com/in/mumtaz-ahmad-3151a6243/',	'LinkedIn',	'Junior',	'Junior',	'.NET',	NULL,	NULL,	'resumes/mumtaz_ahmad_resume.pdf',	'\"[{\\\"name\\\":\\\"9\\\",\\\"exp_years\\\":\\\"3\\\",\\\"exp_months\\\":\\\"6\\\"},{\\\"name\\\":\\\"8\\\",\\\"exp_years\\\":\\\"3\\\",\\\"exp_months\\\":\\\"6\\\"},{\\\"name\\\":\\\"1\\\",\\\"exp_years\\\":\\\"1\\\",\\\"exp_months\\\":null}]\"',	'2025-07-11 12:07:22',	'2025-07-11 12:07:22'),
(23,	0,	'Kartik',	'Rana',	'kartikrana7196@gmail.com',	'9536738789',	NULL,	NULL,	6,	'AppTechies',	NULL,	10000.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Junior',	'Junior',	'Designer',	NULL,	NULL,	'resumes/kartik_rana_resume.pdf',	'\"[{\\\"name\\\":\\\"41\\\",\\\"exp_years\\\":null,\\\"exp_months\\\":\\\"6\\\"},{\\\"name\\\":\\\"42\\\",\\\"exp_years\\\":null,\\\"exp_months\\\":\\\"6\\\"}]\"',	'2025-07-11 13:12:45',	'2025-07-11 13:12:45'),
(24,	0,	'Mohammad',	'Umar',	'mohdumar707080@gmail.com',	'8176837301',	NULL,	NULL,	6,	'Xpertiks',	10000.00,	12000.00,	0,	NULL,	0,	0,	NULL,	'https://www.linkedin.com/in/umar98/',	'LinkedIn',	'Junior',	'Junior',	'Designer',	NULL,	NULL,	NULL,	'\"[{\\\"name\\\":\\\"41\\\",\\\"exp_years\\\":null,\\\"exp_months\\\":\\\"6\\\"},{\\\"name\\\":\\\"42\\\",\\\"exp_years\\\":null,\\\"exp_months\\\":\\\"6\\\"},{\\\"name\\\":\\\"45\\\",\\\"exp_years\\\":null,\\\"exp_months\\\":\\\"6\\\"}]\"',	'2025-07-11 13:33:15',	'2025-07-11 13:33:15'),
(25,	0,	'Tamanna',	'.',	'tamannachoudhary176@gmail.com',	'8580417110',	NULL,	NULL,	6,	'RV Technology',	NULL,	12.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Trainee',	'Junior',	'Designer',	'interview schedule',	NULL,	NULL,	'\"[{\\\"name\\\":\\\"41\\\",\\\"exp_years\\\":null,\\\"exp_months\\\":\\\"6\\\"},{\\\"name\\\":\\\"42\\\",\\\"exp_years\\\":null,\\\"exp_months\\\":\\\"6\\\"},{\\\"name\\\":\\\"45\\\",\\\"exp_years\\\":null,\\\"exp_months\\\":\\\"6\\\"}]\"',	'2025-07-11 13:34:19',	'2025-07-11 13:34:19'),
(26,	0,	'PREM',	'KUMAR',	'premkuma5151@gmail.com',	'9041822120',	NULL,	6,	NULL,	'premkuma5151@gmail.com',	NULL,	10000.00,	0,	NULL,	NULL,	0,	NULL,	'https://www.linkedin.com/in/prem-kumar-636481372/',	'LinkedIn',	'Junior',	'Junior',	'Designer',	NULL,	NULL,	'resumes/prem_kumar_resume.pdf',	'\"[{\\\"name\\\":\\\"41\\\",\\\"exp_years\\\":null,\\\"exp_months\\\":\\\"6\\\"},{\\\"name\\\":\\\"42\\\",\\\"exp_years\\\":null,\\\"exp_months\\\":\\\"6\\\"},{\\\"name\\\":\\\"45\\\",\\\"exp_years\\\":null,\\\"exp_months\\\":\\\"6\\\"}]\"',	'2025-07-11 13:38:16',	'2025-07-11 13:38:16'),
(27,	0,	'Pranshu',	'Deval',	'pranshudeval4@gmail.com',	'9667584192',	NULL,	2,	7,	'INet Build',	50000.00,	91666.00,	0,	NULL,	0,	0,	NULL,	'https://www.linkedin.com/in/pranshu-deval-31331b14b/',	'LinkedIn',	'Junior',	'Junior',	'.NET',	NULL,	NULL,	'resumes/pranshu_deval_resume.pdf',	'\"[{\\\"name\\\":\\\"9\\\",\\\"exp_years\\\":null,\\\"exp_months\\\":\\\"3\\\"},{\\\"name\\\":\\\"8\\\",\\\"exp_years\\\":\\\"2\\\",\\\"exp_months\\\":null},{\\\"name\\\":\\\"1\\\",\\\"exp_years\\\":\\\"1\\\",\\\"exp_months\\\":\\\"5\\\"}]\"',	'2025-07-11 13:52:05',	'2025-07-11 13:52:05'),
(28,	0,	'Jaswant',	'Kumar',	'jassverma744@gmail.com',	'9877699790',	NULL,	NULL,	NULL,	NULL,	NULL,	12.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Trainee',	'Junior',	'Designer',	'Not interested to work on Figma',	NULL,	'resumes/jaswant_kumar_resume.pdf',	'[{\"name\":\"41\",\"exp_years\":null,\"exp_months\":\"6\"},{\"name\":\"42\",\"exp_years\":null,\"exp_months\":\"6\"}]',	'2025-07-11 13:52:33',	'2025-07-11 13:54:39'),
(29,	0,	'Narayan',	'Singh',	'narayansinghbti@gmail.com',	'9876162402',	NULL,	5,	NULL,	NULL,	NULL,	0.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Senior',	'Senior',	'Others',	'Currently not required',	NULL,	'resumes/narayan_singh_resume.pdf',	'\"[]\"',	'2025-07-11 13:58:11',	'2025-07-11 13:58:11'),
(30,	0,	'Manpreet',	'Kaur',	'manpreetkaur789549@gmail.com',	'9914670789',	NULL,	NULL,	NULL,	NULL,	NULL,	0.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Trainee',	'Junior',	'Designer',	'No Experience in Figma',	NULL,	'resumes/manpreet_kaur_resume.pdf',	'\"[]\"',	'2025-07-11 14:08:53',	'2025-07-11 14:08:53'),
(31,	0,	'MOHIT',	'RANA',	'mohitrana080k@gmail.comz',	'9888463681',	NULL,	NULL,	2,	NULL,	NULL,	10000.00,	0,	NULL,	NULL,	0,	NULL,	'https://www.linkedin.com/in/mohit-rana-134832238/',	'LinkedIn',	'Junior',	'Junior',	'Designer',	NULL,	NULL,	'resumes/mohit_rana_resume.pdf',	'\"[{\\\"name\\\":\\\"41\\\",\\\"exp_years\\\":null,\\\"exp_months\\\":\\\"2\\\"},{\\\"name\\\":\\\"42\\\",\\\"exp_years\\\":null,\\\"exp_months\\\":\\\"2\\\"},{\\\"name\\\":\\\"45\\\",\\\"exp_years\\\":null,\\\"exp_months\\\":\\\"2\\\"}]\"',	'2025-07-11 14:12:08',	'2025-07-11 14:12:08'),
(32,	0,	'Manoj',	'Kumar',	'manojraw710@gmail.com',	'7986611207',	NULL,	NULL,	NULL,	NULL,	94.00,	108300.00,	0,	NULL,	45,	1,	30,	NULL,	'LinkedIn',	'Senior',	'Senior',	'.NET',	'Exceed Budget',	NULL,	'resumes/manoj_kumar_resume_2.pdf',	'[{\"name\":\"9\",\"exp_years\":\"4\",\"exp_months\":\"5\"}]',	'2025-07-11 14:24:09',	'2025-07-11 14:32:16'),
(33,	0,	'Ankush',	'Kumar',	'ak626513@gmail.com',	'8091740972',	NULL,	1,	9,	'CS Infotech',	23500.00,	40000.00,	0,	NULL,	0,	0,	NULL,	NULL,	'LinkedIn',	'Junior',	'Senior',	'.NET',	'High salary expectataion',	NULL,	'resumes/ankush_kumar_resume.pdf',	'\"[{\\\"name\\\":\\\"9\\\",\\\"exp_years\\\":\\\"1\\\",\\\"exp_months\\\":\\\"9\\\"},{\\\"name\\\":\\\"8\\\",\\\"exp_years\\\":\\\"1\\\",\\\"exp_months\\\":\\\"9\\\"}]\"',	'2025-07-11 14:56:30',	'2025-07-11 14:56:30'),
(34,	0,	'DEEPANSHI',	'Rana',	'ranadeepanshi8@gmail.com',	'7696928177',	NULL,	7,	NULL,	'Redblink Technologies',	80000.00,	108333.00,	0,	NULL,	NULL,	0,	NULL,	'https://www.linkedin.com/in/deepanshi-rana-058a8a160/',	'LinkedIn',	'Senior',	'Senior',	'WordPress',	NULL,	NULL,	'resumes/deepanshi_rana_resume.pdf',	'\"[{\\\"name\\\":\\\"53\\\",\\\"exp_years\\\":\\\"5\\\",\\\"exp_months\\\":null}]\"',	'2025-07-11 15:11:37',	'2025-07-11 15:11:37'),
(35,	0,	'Nisha',	'Talwar',	'nishakashyap342@gmail.com',	'9815882033',	NULL,	5,	5,	'CodexGeeks LLP',	46000.00,	60000.00,	1,	'58000',	15,	0,	NULL,	'https://www.linkedin.com/in/nisha-talwar-4a135217a/',	'LinkedIn',	'Senior',	'Senior',	'WordPress',	NULL,	NULL,	'resumes/nisha_talwar_resume.pdf',	'\"[{\\\"name\\\":\\\"53\\\",\\\"exp_years\\\":\\\"5\\\",\\\"exp_months\\\":\\\"5\\\"}]\"',	'2025-07-11 19:10:14',	'2025-07-11 19:10:14'),
(36,	0,	'Twinkle',	'Mittal',	'twinklemittal01@gmail.com',	'9041136181',	NULL,	4,	NULL,	'Stegpearl Technology Pvt. Ltd.',	48000.00,	62500.00,	0,	NULL,	0,	0,	NULL,	'https://www.linkedin.com/in/designertwinkle/',	'LinkedIn',	'Senior',	'Senior',	'WordPress',	NULL,	NULL,	'resumes/twinkle_mittal_resume.pdf',	'\"[{\\\"name\\\":\\\"53\\\",\\\"exp_years\\\":\\\"4\\\",\\\"exp_months\\\":null}]\"',	'2025-07-11 19:32:51',	'2025-07-11 19:32:51'),
(37,	0,	'Neha',	'Sharma',	'neha90220@gmail.com',	'7087640974',	NULL,	8,	NULL,	'Krishna Innovative Software Pvt. Ltd.',	78000.00,	85000.00,	0,	NULL,	30,	0,	NULL,	NULL,	'LinkedIn',	'Senior',	'Senior',	'PHP',	'In Process',	'New Opportunity',	'resumes/neha_sharma_resume.docx',	'\"[{\\\"name\\\":\\\"53\\\",\\\"exp_years\\\":\\\"8\\\",\\\"exp_months\\\":null},{\\\"name\\\":\\\"315\\\",\\\"exp_years\\\":\\\"8\\\",\\\"exp_months\\\":null},{\\\"name\\\":\\\"305\\\",\\\"exp_years\\\":\\\"8\\\",\\\"exp_months\\\":null},{\\\"name\\\":\\\"205\\\",\\\"exp_years\\\":\\\"3\\\",\\\"exp_months\\\":null}]\"',	'2025-07-14 14:07:25',	'2025-07-14 14:07:25'),
(38,	0,	'Neha',	'Sharma',	'neha90220@gmail.com',	'7087640974',	NULL,	8,	NULL,	'Krishna Innovative Software Pvt. Ltd.',	78000.00,	85000.00,	0,	NULL,	30,	0,	NULL,	NULL,	'LinkedIn',	'Senior',	'Senior',	'PHP',	'In Process',	'New Opportunity',	'resumes/neha_sharma_resume.docx',	'\"[{\\\"name\\\":\\\"53\\\",\\\"exp_years\\\":\\\"8\\\",\\\"exp_months\\\":null},{\\\"name\\\":\\\"315\\\",\\\"exp_years\\\":\\\"8\\\",\\\"exp_months\\\":null},{\\\"name\\\":\\\"305\\\",\\\"exp_years\\\":\\\"8\\\",\\\"exp_months\\\":null},{\\\"name\\\":\\\"205\\\",\\\"exp_years\\\":\\\"3\\\",\\\"exp_months\\\":null}]\"',	'2025-07-14 14:07:25',	'2025-07-14 14:07:25'),
(39,	0,	'Khushboo',	'Rani',	'rkhusboo08@gmail.com',	'7307495208',	NULL,	2,	NULL,	NULL,	NULL,	0.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Mid-Level',	'Mid-Level',	'PHP',	'No Expereince in Shopify',	NULL,	NULL,	'\"[{\\\"name\\\":\\\"315\\\",\\\"exp_years\\\":\\\"2\\\",\\\"exp_months\\\":null},{\\\"name\\\":\\\"53\\\",\\\"exp_years\\\":\\\"2\\\",\\\"exp_months\\\":null}]\"',	'2025-07-14 14:40:20',	'2025-07-14 14:40:20'),
(40,	0,	'Archana',	'.',	'archu6284@gmail.com',	'6284894499',	NULL,	NULL,	NULL,	NULL,	NULL,	0.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	NULL,	'Mid-Level',	'PHP',	'No major expeince in shopify',	NULL,	'resumes/archana_._resume.pdf',	'\"[{\\\"name\\\":\\\"53\\\",\\\"exp_years\\\":\\\"2\\\",\\\"exp_months\\\":\\\"0\\\"}]\"',	'2025-07-14 17:59:31',	'2025-07-14 17:59:31'),
(41,	0,	'Himanshi',	'Rai',	'himanshirai7@gmail.com',	'7814521487',	NULL,	2,	4,	NULL,	NULL,	0.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Mid-Level',	'Mid-Level',	'PHP',	'No Experience in WP and shopify',	NULL,	'resumes/himanshi_rai_resume.pdf',	'\"[]\"',	'2025-07-14 18:04:09',	'2025-07-14 18:04:09'),
(42,	0,	'Himanshi',	'Rai',	'himanshirai7@gmail.com',	'7814521487',	NULL,	2,	4,	NULL,	NULL,	0.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Mid-Level',	'Mid-Level',	'PHP',	'No Experience in WP and shopify',	NULL,	'resumes/himanshi_rai_resume_1.pdf',	'\"[]\"',	'2025-07-14 18:04:09',	'2025-07-14 18:04:09'),
(43,	0,	'Ritu',	'Sharma',	'ritusharma946@gmail.com',	'9417028007',	NULL,	NULL,	NULL,	NULL,	NULL,	0.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Senior',	'Senior',	'.NET',	'Lookin for remote job',	NULL,	'resumes/ritu_sharma_resume.pdf',	'\"[]\"',	'2025-07-14 18:07:38',	'2025-07-14 18:07:38'),
(44,	0,	'Kamesh',	'Sharma',	'kameshsharma087@gmail.com',	'9857100372',	NULL,	NULL,	NULL,	NULL,	NULL,	0.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Senior',	'Senior',	'PHP',	'Male Candiadte',	NULL,	'resumes/kamesh_sharma_resume.pdf',	'\"[]\"',	'2025-07-14 18:21:49',	'2025-07-14 18:21:49'),
(45,	0,	'Kritika',	'Vashisht',	'kritika.vashisht01@gmail.com',	'7018814383',	NULL,	NULL,	NULL,	NULL,	NULL,	0.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Mid-Level',	'Mid-Level',	'PHP',	'No Experience in Shopify',	NULL,	'resumes/kritika_vashisht_resume.pdf',	'\"[]\"',	'2025-07-14 19:37:56',	'2025-07-14 19:37:56'),
(46,	0,	'Shagun',	'.',	'shagunrathorrrrr@gmail.com',	'8988590836',	NULL,	NULL,	NULL,	NULL,	NULL,	0.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Junior',	'Junior',	'.NET',	'only 6 months experience',	NULL,	'resumes/shagun_._resume.pdf',	'\"[]\"',	'2025-07-14 19:50:48',	'2025-07-14 19:50:48'),
(47,	0,	'Vishali',	'.',	'vishali270619@gmail.com',	'7876113809',	NULL,	NULL,	NULL,	NULL,	NULL,	50000.00,	0,	NULL,	45,	0,	NULL,	NULL,	'LinkedIn',	'Mid-Level',	'Mid-Level',	'.NET',	'interview schedule',	'carrer Growth',	'resumes/vishali_._resume.pdf',	'\"[]\"',	'2025-07-15 18:33:38',	'2025-07-15 18:33:38'),
(48,	0,	'Gursewak',	'Singh',	'sewaksaggu68@gmail.com',	'8283931659',	NULL,	NULL,	NULL,	NULL,	NULL,	0.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Mid-Level',	'Mid-Level',	'PHP',	'Currently not required',	NULL,	'resumes/gursewak_singh_resume.pdf',	'\"[{\\\"name\\\":\\\"53\\\",\\\"exp_years\\\":\\\"2\\\",\\\"exp_months\\\":\\\"0\\\"}]\"',	'2025-07-15 18:38:25',	'2025-07-15 18:38:25'),
(49,	0,	'Parbal',	'.',	'ollaparbal@gmail.com',	'9125240969',	NULL,	NULL,	NULL,	NULL,	70000.00,	100000.00,	0,	NULL,	0,	0,	NULL,	NULL,	'LinkedIn',	'Mid-Level',	'Mid-Level',	'.NET',	'High salary expectataion',	'carrer growth',	'resumes/parbal_._resume.pdf',	'\"[]\"',	'2025-07-15 18:54:30',	'2025-07-15 18:54:30'),
(50,	0,	'Vikas',	'Gour',	'vikasgour365@gmail.com',	'9669912643',	NULL,	NULL,	NULL,	NULL,	NULL,	0.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Mid-Level',	'Mid-Level',	'.NET',	'.',	NULL,	'resumes/vikas_gour_resume.pdf',	'\"[]\"',	'2025-07-15 18:55:41',	'2025-07-15 18:55:41'),
(51,	0,	'Sushant',	'Banyal',	'sushantkk869@gmail.com',	'7876140018',	NULL,	NULL,	NULL,	NULL,	NULL,	0.00,	0,	NULL,	0,	0,	NULL,	NULL,	'LinkedIn',	'Junior',	'Junior',	'.NET',	'Fresher',	NULL,	'resumes/sushant_banyal_resume.pdf',	'\"[]\"',	'2025-07-15 18:57:27',	'2025-07-15 18:57:27'),
(52,	0,	'Prince',	'Chand',	'prince.chand.dev@gmail.com',	'9888725336',	NULL,	NULL,	NULL,	NULL,	NULL,	0.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Mid-Level',	'Mid-Level',	'.NET',	'.',	NULL,	'resumes/prince_chand_resume.pdf',	'\"[{\\\"name\\\":\\\"9\\\",\\\"exp_years\\\":\\\"2\\\",\\\"exp_months\\\":\\\"6\\\"}]\"',	'2025-07-15 19:01:26',	'2025-07-15 19:01:26'),
(53,	0,	'Anu',	'Kaushal',	'anuthakur01885@gmail.com',	'8307962146',	NULL,	3,	5,	NULL,	35000.00,	45000.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Mid-Level',	'Mid-Level',	'.NET',	NULL,	'Lack of Projects',	'resumes/anu_kaushal_resume.pdf',	NULL,	'2025-07-15 20:15:18',	'2025-07-15 20:15:57'),
(54,	0,	'Yash',	'Rajput',	'yashbarampur@gmail.com',	'8171711680',	NULL,	1,	8,	NULL,	NULL,	0.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Junior',	'Mid-Level',	'Flutter',	'Looking for Remote Option',	NULL,	'resumes/yash_rajput_resume.pdf',	'\"[{\\\"name\\\":\\\"309\\\",\\\"exp_years\\\":\\\"1\\\",\\\"exp_months\\\":\\\"8\\\"}]\"',	'2025-07-16 13:07:22',	'2025-07-16 13:07:22'),
(55,	0,	'Anuj',	'Chauhan',	'thakuranuj5780@gmail.com',	'7018584973',	NULL,	NULL,	NULL,	NULL,	NULL,	0.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Mid-Level',	'Mid-Level',	'Flutter',	'.',	NULL,	'resumes/anuj_chauhan_resume.pdf',	NULL,	'2025-07-16 13:10:50',	'2025-07-16 13:11:54'),
(56,	0,	'Sandeep',	'Thakur',	'gs071109@gmail.com',	'7837700488',	NULL,	NULL,	NULL,	NULL,	NULL,	0.00,	0,	NULL,	NULL,	0,	NULL,	NULL,	'LinkedIn',	'Senior',	'Senior',	'Flutter',	'.',	NULL,	'resumes/sandeep_thakur_resume.pdf',	'\"[{\\\"name\\\":\\\"309\\\",\\\"exp_years\\\":\\\"4\\\",\\\"exp_months\\\":\\\"0\\\"}]\"',	'2025-07-16 13:18:53',	'2025-07-16 13:18:53');

DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `digi_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `celb_dob` date NOT NULL,
  `blood_group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` int(11) NOT NULL DEFAULT '0',
  `emergency_contacts` text COLLATE utf8mb4_unicode_ci,
  `official_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voter_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_lead` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `exp_years` int(11) DEFAULT NULL,
  `exp_months` int(11) DEFAULT NULL,
  `salary` text COLLATE utf8mb4_unicode_ci,
  `inc_years` int(11) DEFAULT NULL,
  `inc_months` int(11) DEFAULT NULL,
  `probation_end` date DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `address_perm` text COLLATE utf8mb4_unicode_ci,
  `state_perm` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_perm` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_perm` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_perm` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_local` text COLLATE utf8mb4_unicode_ci,
  `state_local` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_local` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_local` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_local` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acc_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acc_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirm_acc_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skills` text COLLATE utf8mb4_unicode_ci,
  `documents` text COLLATE utf8mb4_unicode_ci,
  `previous_companies` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `employees` (`id`, `digi_id`, `gender`, `dob`, `celb_dob`, `blood_group`, `phone`, `is_approved`, `emergency_contacts`, `official_email`, `email`, `voter_id`, `pan`, `aadhar`, `designation`, `team_lead`, `joining_date`, `exp_years`, `exp_months`, `salary`, `inc_years`, `inc_months`, `probation_end`, `release_date`, `address_perm`, `state_perm`, `city_perm`, `zip_perm`, `country_perm`, `address_local`, `state_local`, `city_local`, `zip_local`, `country_local`, `acc_name`, `acc_no`, `confirm_acc_no`, `bank_name`, `ifsc`, `branch_address`, `profile_image`, `skills`, `documents`, `previous_companies`, `created_at`, `updated_at`) VALUES
(1,	'DS001',	'Male',	'1990-07-04',	'1990-07-04',	'B+',	'9478806550',	2,	'[{\"name\":\"Hardeep Kaur\",\"relation\":\"Wife\",\"phone\":\"8284837016\"},{\"name\":\"Gurinder Singh\",\"relation\":\"Father\",\"phone\":\"9478806431\"}]',	'parampreet@digisoftsolution.com',	'parampreet479@gmail.com',	NULL,	'DTIPS0962M',	'956415531744',	'Team Lead',	'22',	'2013-06-13',	14,	0,	'eyJpdiI6IllHR09rd0hSWXNXeFdpanlWZlUwbWc9PSIsInZhbHVlIjoiZGJLOVdOZXlYSmhCRzRGbFBWTFVOYno5VlVza3VKNlNIS2NoaEdsNURBcz0iLCJtYWMiOiI1NDJlMDQzZmQ5ODllZDYyOTI0MTAzZTIxNTQ4MTIyNDUwMjIxNjdkMzhhYTU5M2FkOWVlM2IyMThmMWU5ZmY3IiwidGFnIjoiIn0=',	1,	0,	NULL,	NULL,	'T2-102, Acme Eden Court, Sector 91',	'Punjab',	'Mohali',	'140307',	'India',	'T2-102, Acme Eden Court, Sector 91',	'Punjab',	'Mohali',	'140307',	'India',	'Parampreet Singh',	'01541000111891',	'01541000111891',	'HDFC',	'HDFC0000154',	'Zirakpur',	'profile_images/QwXWtysTof2gytmpKEwfBh7XP9wFzr3Sx4xrDEYD.jpg',	'[{\"name\":\"1\",\"years\":\"4\",\"months\":\"0\"},{\"name\":{\"name\":\"9\",\"years\":\"6\",\"months\":\"0\"},\"years\":0,\"months\":0},{\"name\":{\"name\":\"15\",\"years\":\"14\",\"months\":\"0\"},\"years\":0,\"months\":0}]',	'[{\"type\":\"PAN\",\"file_path\":\"documents\\/7Ox15eeokhOTvOeuVjO2nqXLFbjYKNugIAz3XY0o.png\"},{\"type\":\"Adhaar\",\"file_path\":\"documents\\/If9Ol3IbPGM8wuR3U39YF45VbTP1TI9GFAHbeSEW.jpg\"},{\"type\":null,\"file_path\":\"documents\\/Rg7kOibqNOKkKUx7LIku34v0v1zZrPjbAQrjEddw.pdf\"}]',	'[{\"company\":\"KIS\",\"salary\":\"30000\"}]',	NULL,	'2025-07-08 16:41:17'),
(48,	'',	'Female',	'1991-01-30',	'1991-01-30',	'B+',	'8284837016',	2,	'[{\"name\":\"Parampreet Singh\",\"relation\":\"Husband\",\"phone\":\"9478806550\"},{\"name\":\"Gurinder Singh\",\"relation\":\"Father\",\"phone\":\"9478806431\"}]',	'hardeep@digisoftsolution.com',	'nancy_17@ymail.com',	NULL,	'DGQPK9447E',	'217246297574',	'Team Lead',	'22',	'2017-04-10',	8,	3,	'eyJpdiI6Ii8zcVF5dU4vWm5oY1kyRHFyaHZyZlE9PSIsInZhbHVlIjoiMk9LdkNRdWdzaEFGbHh3UEhzUVBKbGZYUHZZZWJCenpsT3kzc016UzJaUT0iLCJtYWMiOiJhNDZjNjAzNzY3M2Y0YjhjNjdiN2RmYjA2YjczZWIxODZjYTNhNGJmZGJkZWIwODA3MjY5NTNhY2FhNWY3MGMwIiwidGFnIjoiIn0=',	1,	0,	NULL,	NULL,	'T2-102, Acme Eden Court, Sector 91',	'Punjab',	'Mohali',	'140307',	'India',	'T2-102, Acme Eden Court, Sector 91',	'Punjab',	'Mohali',	'140307',	'India',	'Hardeep Kaur',	'50100165130107',	'50100165130107',	'HDFC',	'HDFC0000154',	'Zirakpur',	'profile_images/fMaGjd4bx4VFaWj7Jkx8uQBWPwq3U1hOxARW8Kt0.jpg',	'[{\"name\":\"58\",\"years\":\"8\",\"months\":\"3\"},{\"name\":\"57\",\"years\":\"8\",\"months\":\"3\"},{\"name\":\"56\",\"years\":\"8\",\"months\":\"3\"}]',	'[{\"type\":\"Adhaar\",\"file_path\":\"documents\\/hardeep_kaur-adhaar.pdf\"},{\"type\":\"PAN\",\"file_path\":\"documents\\/hardeep_kaur-pan.pdf\"}]',	'[]',	'2025-07-08 16:46:43',	'2025-07-10 13:00:20'),
(49,	'',	'Male',	'1990-01-26',	'1990-01-26',	'B+',	'7696444438',	0,	'[{\"name\":\"Monika\",\"relation\":\"Wife\",\"phone\":\"9877288340\"}]',	'kapil@digisoftsolution.com',	'kapil.it.sharma@gmail.com',	NULL,	'DGQPK9447E',	'217246297574',	'Team Lead',	'22',	'2013-06-13',	14,	0,	'eyJpdiI6ImRtUUM5RFFJZTF3Tng5ZkF6ZHcwTXc9PSIsInZhbHVlIjoiZUsrSTBMaTdaVlg4UGwyZWhrenNhL3dXMGpnMUhIRUhOMGhOM3poTjc5Yz0iLCJtYWMiOiI3NDFmODg4OTRkMWE4MGMxZDQ3Nzg4NGQ3ZjhhYzI3MjFmY2I3MTdkNjI4YzEwNjdiNGVlMGM0MWIyNTBlOTMzIiwidGFnIjoiIn0=',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-07-08 19:18:26',	'2025-07-08 19:18:26'),
(50,	'',	'Female',	'2003-03-05',	'2003-03-05',	'O+',	'9015000150',	2,	'[{\"name\":\"Anil Kumar\",\"relation\":\"Father\",\"phone\":\"9805399310\"}]',	'vanshika.sharma@digisoftsolution.com',	'vanshuvanshika833@gmail.com',	NULL,	'CJKPV7017B',	'446373201204',	'HR Executive',	'33',	'2024-11-25',	NULL,	NULL,	'eyJpdiI6InI2bldYZEhNQTQ5R0VFWDJQRmMyTWc9PSIsInZhbHVlIjoiME9USXVUQTlyYy9NWW5JeVlPZEtkT2JlSENvdmRIUFE3NlpWNWpoZmRtaz0iLCJtYWMiOiJlZjBmZjg4MjVkMDI2YzZhZDZhZDc4NWQzMDkwM2ViOTAyNzUzODljMDkxZjE4OGI1MWZjNDdiNGYzNmIyNzAyIiwidGFnIjoiIn0=',	1,	0,	'2025-02-25',	NULL,	'VPO Pragpur, Teh. Dehra,',	'Himachal Pradesh',	'Distt.Kangra',	'177107',	'India',	'#508, Phase 3B1, Sector 60',	'Punjab',	'mohali',	'160059',	'India',	'Vanshika',	'6153000100065142',	'6153000100065142',	'PNB',	'PUNB0615300',	NULL,	'profile_images/vanshika_sharma_profile.png',	'[{\"name\":\"56\",\"years\":\"1\",\"months\":\"4\"}]',	NULL,	'[{\"company\":\"TechNaitra IT Solution\",\"salary\":\"15000\"}]',	'2025-07-10 13:27:54',	'2025-07-10 13:51:31'),
(51,	'',	'Female',	'1998-11-21',	'1998-11-21',	'O+',	'8580663893',	2,	'[{\"name\":\"Ranjana Kumari\",\"relation\":\"Mother\",\"phone\":\"9805622931\"}]',	'nitisha@digisoftsolution.com',	'nitisharma950@gmail.com',	NULL,	'MBMPS2304C',	'728125445658',	'HR Executive',	'33',	'2025-01-01',	2,	8,	'eyJpdiI6Im1WTHRNVHllUmpad1RKY0E0YWdaYkE9PSIsInZhbHVlIjoiMnZyYjhWeW8rYWY4a29oYmMwelBrNHJFb2ZRakZRNmw4TEgremVmOE9BRT0iLCJtYWMiOiJmYTIwN2M1MjdjMzdiYTMxNmE0YzY5M2JmZmYyMWZiZTM0NGViZTdiOTQ2YjI5OWZjMTE4NzQ1MzU5MGNkM2Q4IiwidGFnIjoiIn0=',	1,	0,	'2025-08-01',	NULL,	'Village Amrehra, PO malanger, Amrera (8/2), Una, Himachal Pradesh, 174308',	'Himachal Pradesh',	'Una',	'174308',	'India',	'#1578, Phase 5, Mohali',	'Punjab',	'Mohali',	'160059',	'India',	'Nitisha Sharma',	'435401501603',	'435401501603',	'ICICI Bank',	'ICIC0003421',	'Himachal Pradesh',	NULL,	'[{\"name\":\"56\",\"years\":\"2\",\"months\":\"8\"}]',	NULL,	'[{\"company\":\"Dight Infotech\",\"salary\":\"8000\"},{\"company\":\"Zenid Infotech\",\"salary\":\"12000\"},{\"company\":\"Ingenious Netsoft\",\"salary\":\"22000\"}]',	'2025-07-10 13:50:31',	'2025-07-10 14:03:01'),
(52,	'DS188',	'Male',	'2003-10-24',	'2003-10-24',	'O+',	'8894828305',	0,	'[{\"name\":\"Suresh Kumar\",\"relation\":\"Uncle\",\"phone\":\"9023237912\"}]',	'lovish@digisoftsolution.com',	'lovish.rajput164@gmail.com',	NULL,	'CAIPL2917D',	'968163563774',	'Intern',	'34',	'2025-06-09',	NULL,	6,	'0',	0,	2,	'2025-09-01',	NULL,	'Village Mittian, PO Mittian, Tehsil Nalagarh, Distt-Solan',	'Himachal Pradesh',	'Solan',	'174102',	'India',	'Balongi',	'Punjab',	'Mohali',	'160055',	'India',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-07-10 15:05:57',	'2025-07-10 16:38:22'),
(54,	'DS167',	'Male',	'2004-07-11',	'2004-07-11',	'B+',	'9463705356',	1,	'[{\"name\":\"Sumash\",\"relation\":\"Brother\",\"phone\":\"7878990001\"}]',	'lakesh@digisoftsolution.com',	'luckys90001@gmail.com',	NULL,	'SUMPS5702K',	'289259390753',	'Junior Developer',	'34',	'2024-12-16',	0,	8,	'eyJpdiI6IkQyakZkVThYKytPdnBYM2tyUndhL0E9PSIsInZhbHVlIjoiSmkrazVrd0ZNTTlGOC9ZbU8xQWFoZSs5NExFZ3VmcytDVEM3Y25XcG5IVT0iLCJtYWMiOiI4NWE4Mzk3NzE2ODg0YTRmNDJlMzhhM2I0OTc5YmQ1OTM5MTFjOGIxMjFhNDFjYWFiNzlkNGYwNDViOWI2ZjUzIiwidGFnIjoiIn0=',	0,	10,	'2025-02-17',	NULL,	'Vill- Rassauli, Block/Tehsil- Patran, District- Patiala Punjab',	'Punjab',	'Patiala',	'147105',	'India',	'#3112, Sector 71',	'Punjab',	'Mohali',	'160071',	'India',	'Lakesh Sharma',	'6822001700010094',	'6822001700010094',	'Punjab National Bank',	'PUNB0682200',	NULL,	NULL,	'[{\"name\":\"9\",\"years\":\"8\",\"months\":\"0\"}]',	NULL,	'[]',	'2025-07-10 19:41:36',	'2025-07-11 14:37:09'),
(55,	'DS163',	'Male',	'2000-07-16',	'2000-07-16',	'B−',	'6396949823',	1,	'[{\"name\":\"Ravindra Pundir\",\"relation\":\"Father\",\"phone\":\"9012828899\"}]',	'vivek.pundir@digisoftsolution.com',	'pundirvivek1313@gmail.com',	NULL,	'FICPP8498E',	'774187300782',	'Software Engineer',	'34',	'2024-12-04',	3,	0,	'eyJpdiI6IjFCWDFyYlBqa1RmRVpEVUVWNlJsMFE9PSIsInZhbHVlIjoiREJTVnlyeUlOMm8wUEdyMTc2eU00d21qV1R5d1ZrT000TkJCSzdGaGczbz0iLCJtYWMiOiI4ZGJiYzUyMzJlY2Y5OGUwODIwMzc0NzFkNTMzZTJiZDA2YWExOWVkY2MzOTUyNWIwYjA1MjNhODgyMjM2ZDJmIiwidGFnIjoiIn0=',	1,	0,	'2025-01-06',	'2025-07-11',	'Village Bhamela, PO Jasoi, Muzaffarnagar, Uttar Pradesh',	'Uttar Pradesh',	'Muzaffarnagar',	'251301',	'India',	'Balongi',	'Punjab',	'Mohali',	'160055',	'India',	'Vivek Pundir',	'660001507874',	'660001507874',	'ICICI BANK',	'ICIC0006600',	'Sector 70, Mohali',	NULL,	'[]',	NULL,	'[]',	'2025-07-11 16:39:51',	'2025-07-11 16:52:12'),
(56,	'DS157',	'Male',	'2002-03-05',	'2002-03-05',	'B+',	'8261029536',	1,	'[{\"name\":\"Jasvinder Singh\",\"relation\":\"Brother\",\"phone\":\"8626809696\"}]',	'jaivinder.singh@digisoftsolution.com',	'jimmyjaivinder98@gmail.com',	NULL,	'ODJPS4435P',	'851698764716',	'Junior Developer',	'22',	'2024-11-18',	2,	0,	'eyJpdiI6InZxeDM4NkNBVDVJVXVoMU4yR2hETEE9PSIsInZhbHVlIjoiNFFuZVJVSlBtRnNjYThsc0pWc3NaSHZBbGp3YTB1UTZxYnE2OHF1TUl1OD0iLCJtYWMiOiI1ZTA2N2UxYjJmMWNkYjlmODJlMTNkOTYzYTUyOWJlZGNmZDQ3ZTBlOTllZDRjYzQ3ZDJmYzRhMDQ5MGViZmVkIiwidGFnIjoiIn0=',	1,	0,	'2024-12-19',	NULL,	'#210 Ghumaran wala mohalla, Old Rajpura, Patiala.',	'Punjab',	'Patiala',	'140401',	'India',	'#1555, Sec.59, Phase 5 Mohali.',	'Punjab',	'Mohali',	'160059',	'India',	'Jaivinder Singh',	'0916104000072715',	'0916104000072715',	'IDBI',	'IBKL0000916',	'Patiala-Chandigarh Road, near ITI Chowk, Rajpura',	NULL,	'[]',	NULL,	'[]',	'2025-07-11 17:09:20',	'2025-07-11 17:16:48'),
(57,	'DS091',	'Male',	'1995-09-28',	'1995-09-28',	'AB+',	'9041872790',	1,	'[{\"name\":\"Rajiv Sharma\",\"relation\":\"Father\",\"phone\":\"9417069860\"}]',	'vickramjeet.singh@digisoftsolution.com',	'csevicky1@gmail.com',	NULL,	'GRZPS9678N',	'224959019488',	'Software Engineer',	'22',	'2022-09-19',	7,	10,	'eyJpdiI6IktGcEs1N2luei96N2VZVlhXTnVZOHc9PSIsInZhbHVlIjoiMUJqV0UzaWxrajVIV2FjYVIzVkU3S0ZxeENpNGIvbUlGb1JoNEVOd2Njaz0iLCJtYWMiOiJkNjE3NjNiZDI0N2FhNzYwMDk0ZGYyYWQ0NmEyMjhiODkwNTY1Yzc4NmNmOWE4ODUwZWVkNWNjZTJiNzA1YjY3IiwidGFnIjoiIn0=',	1,	0,	'2022-10-20',	NULL,	'Station master Rajiv sharma, Near Gau Dharamshala, LehraGaga, Dist. sangrur',	'Punjab',	'Sangrur',	'148031',	'India',	'#3907 Sunny heights , Kharar,  Punjab',	'Punjab',	'Kharar',	'140301',	'India',	'Vickramjeet Singh`',	'2911911710',	'2911911710',	'Kotak Mahindra Bank',	'KKBK0004098',	'Mauli Baidwan, Punjab',	NULL,	'[]',	'[]',	'[]',	'2025-07-11 17:40:53',	'2025-07-14 19:53:28');

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `hiringportals`;
CREATE TABLE `hiringportals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) NOT NULL,
  `IsPaid` tinyint(1) DEFAULT '0',
  `SubscriptionStartDT` datetime DEFAULT NULL,
  `SubscriptionEndDT` datetime DEFAULT NULL,
  `Notes` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `hiringportals` (`id`, `Title`, `IsPaid`, `SubscriptionStartDT`, `SubscriptionEndDT`, `Notes`, `created_at`, `updated_at`) VALUES
(21,	'Linkedin',	0,	NULL,	NULL,	'N/A',	'2025-07-08 17:17:52',	'2025-07-08 17:53:42');

DROP TABLE IF EXISTS `holidays`;
CREATE TABLE `holidays` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `holiday_date` date NOT NULL,
  `day` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `holidays` (`id`, `title`, `holiday_date`, `day`, `created_at`, `updated_at`) VALUES
(4,	'Republic Day',	'2025-01-26',	'Sunday',	'2025-07-08 16:59:28',	'2025-07-08 16:59:28'),
(5,	'Holi',	'2025-03-14',	'Friday',	'2025-07-10 14:11:42',	'2025-07-10 14:11:42'),
(6,	'Raksha Bandhan',	'2025-08-09',	'Saturday',	'2025-07-10 14:12:21',	'2025-07-10 14:12:21'),
(7,	'Independence  Day',	'2025-08-15',	'Friday',	'2025-07-10 14:12:47',	'2025-07-10 14:12:47'),
(8,	'Gandhi Jayanti',	'2025-10-02',	'Thursday',	'2025-07-10 14:13:08',	'2025-07-10 14:13:08'),
(9,	'Dussehra',	'2025-10-02',	'Thursday',	'2025-07-10 14:13:27',	'2025-07-10 14:13:27'),
(10,	'Diwali',	'2025-10-20',	'Monday',	'2025-07-10 14:14:01',	'2025-07-10 14:14:01'),
(11,	'Diwali',	'2025-10-21',	'Tuesday',	'2025-07-10 14:14:45',	'2025-07-10 14:14:45'),
(12,	'Guru Nanak Jayanti',	'2025-11-05',	'Wednesday',	'2025-07-10 14:15:12',	'2025-07-10 14:15:12'),
(13,	'Christmas',	'2025-12-25',	'Thursday',	'2025-07-10 14:15:37',	'2025-07-10 14:15:37');

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'0001_01_01_000000_create_users_table',	1),
(2,	'0001_01_01_000001_create_cache_table',	1),
(3,	'0001_01_01_000002_create_jobs_table',	1),
(4,	'2025_06_11_064930_create_employees_table',	1),
(5,	'2025_06_12_070542_add_role_to_users_table',	1),
(6,	'2025_06_16_092958_add_is_approved_to_employees_table',	1);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'employee',
  `employee_id` int(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `employee_id`, `created_at`, `updated_at`, `is_deleted`) VALUES
(22,	'Parampreet Singh',	'parampreet@digisoftsolution.com',	NULL,	'$2y$12$SZZLhCBMockV6vKkTDwjoez0IS0zu/ZAAf3iPJATsGoz2z6u0fJlG',	'z4z2dHdtT70YHEp9uBZ4qTYwM3QvutP14NeVu2wBsLfTmrodJlGwZGLeRfax',	'admin',	1,	'2025-06-20 17:10:37',	'2025-07-08 16:32:55',	0),
(33,	'Hardeep Kaur',	'hardeep@digisoftsolution.com',	NULL,	'$2y$12$LPCoiVn1kufcqyuBJFxpHOCZLcZLTemBWhe8YJv6G.G/RHCnj.tuG',	'6XuDKbW6E5PyFfcXpg08qdxosMPdN9lcbgfeDD8DTSYFtljL0aPAspJqiKow',	'admin',	48,	'2025-07-08 16:46:43',	'2025-07-10 13:08:00',	0),
(34,	'Kapil Kumar Sharma',	'kapil@digisoftsolution.com',	NULL,	'$2y$12$bsvy7NFsmYXyktNHoNlqq.eUkxra4mPlTZiryis2O3oz.9ldmf1Iu',	NULL,	'admin',	49,	'2025-07-08 19:18:27',	'2025-07-08 19:18:27',	0),
(35,	'Vanshika Sharma',	'vanshika.sharma@digisoftsolution.com',	NULL,	'$2y$12$eCCZtRlpzBPNyRxw7QAt0.UUxJGkjl9Ukx/4T6GemZrLUAtD0z1ge',	NULL,	'hr',	50,	'2025-07-10 13:27:54',	'2025-07-10 14:00:47',	0),
(36,	'Nitisha Sharma',	'nitisha@digisoftsolution.com',	NULL,	'$2y$12$B7V/BmrpFbnoswspRLhQ1eVXdJqYjhDwCMOQcbU18o5NasABl5Di.',	'cd76qTG9qxX1uczmPohtwXi2ocqcqabFYt721sfZsAy7lXd2xdI465wzjlsh',	'hr',	51,	'2025-07-10 13:50:31',	'2025-07-10 17:04:25',	0),
(37,	'Lovish Rajput',	'lovish@digisoftsolution.com',	NULL,	'$2y$12$X7n.8oHIHLeLzO31njeEUOuAAWxeDUg4f7kCU2BsLwrlboUH1NC/C',	NULL,	'employee',	52,	'2025-07-10 15:05:58',	'2025-07-10 16:38:22',	0),
(39,	'Lakesh Sharma',	'lakesh@digisoftsolution.com',	NULL,	'$2y$12$CVXDE9uUd1yaycZlmws2G./fyIb5GjMGyjNmr8.xTwh.D6dIDKeoS',	NULL,	'employee',	54,	'2025-07-10 19:41:36',	'2025-07-10 19:41:36',	0),
(40,	'Vivek Pundir',	'vivek.pundir@digisoftsolution.com',	NULL,	'$2y$12$uj3BOEbqwfKyVcRC57W/WucBJngdJwx4a6YZTfq7HBmq6K4EWQCKq',	NULL,	'employee',	55,	'2025-07-11 16:39:52',	'2025-07-11 16:39:52',	0),
(41,	'Jaivinder Singh',	'jaivinder.singh@digisoftsolution.com',	NULL,	'$2y$12$90fZ5kMGa9I77d/YsjhvuuIU0gKWQblbscNxQ4B3X/VG0MXkrKC2O',	NULL,	'employee',	56,	'2025-07-11 17:09:20',	'2025-07-11 17:09:20',	0),
(42,	'Vickramjeet Singh',	'vickramjeet.singh@digisoftsolution.com',	NULL,	'$2y$12$Jvaj8bhvUdo9ZmPTWzlu0eHPBR7nyjPYiWQHwxrkLpT6Wnb4rdOp6',	NULL,	'employee',	57,	'2025-07-11 17:40:53',	'2025-07-11 17:40:53',	0);

-- 2025-07-16 06:31:01 UTC
