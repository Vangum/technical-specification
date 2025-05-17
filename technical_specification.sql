-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Время создания: Май 17 2025 г., 16:44
-- Версия сервера: 8.0.35
-- Версия PHP: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `technical_specification`
--

-- --------------------------------------------------------

--
-- Структура таблицы `documents`
--

CREATE TABLE `documents` (
  `id` int NOT NULL,
  `visitor_id` int NOT NULL,
  `doc_type` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `doc_name` varchar(150) NOT NULL,
  `passport_series` int UNSIGNED DEFAULT NULL,
  `passport_number` int UNSIGNED DEFAULT NULL,
  `passport_issue_date` date DEFAULT NULL,
  `passport_issued_by` varchar(250) DEFAULT NULL,
  `passport_unit_code` varchar(7) DEFAULT NULL,
  `license_series_number` bigint UNSIGNED DEFAULT NULL,
  `license_issue_date` date DEFAULT NULL,
  `license_region` varchar(150) DEFAULT NULL,
  `license_issued_by` varchar(250) DEFAULT NULL,
  `other_series_number` bigint UNSIGNED DEFAULT NULL,
  `other_issue_date` date DEFAULT NULL,
  `other_issued_by` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `documents`
--

INSERT INTO `documents` (`id`, `visitor_id`, `doc_type`, `doc_name`, `passport_series`, `passport_number`, `passport_issue_date`, `passport_issued_by`, `passport_unit_code`, `license_series_number`, `license_issue_date`, `license_region`, `license_issued_by`, `other_series_number`, `other_issue_date`, `other_issued_by`) VALUES
(14, 39, 'passport', 'Паспорт', 6538, 377284, '2012-01-03', 'Территориальный отдел МВД России по г. Новосибирску', '061-351', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 41, 'license', 'Водительское удостоверение', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 64, 'passport', 'Паспорт', 8968, 937226, '2013-11-29', 'Отдел МВД России по Нижегородской области в г. Арзамасе', '751-988', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 65, 'other', 'Пропуск', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 23450829, '2022-01-24', 'Организация');

-- --------------------------------------------------------

--
-- Структура таблицы `visitors`
--

CREATE TABLE `visitors` (
  `id` int NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `department` enum('Не выбрано','Коммерческий отдел','Монтажный отдел','Руководящий состав') DEFAULT 'Не выбрано',
  `birth_date` date NOT NULL,
  `post` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `entry_time` datetime NOT NULL,
  `exit_time` datetime NOT NULL,
  `remark` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `visitors`
--

INSERT INTO `visitors` (`id`, `full_name`, `department`, `birth_date`, `post`, `phone`, `entry_time`, `exit_time`, `remark`) VALUES
(39, 'Горшков Святослав Леонидович', 'Коммерческий отдел', '1997-12-12', 'Менеджер', '+7(927)454-35-53', '2025-05-13 08:03:00', '2025-05-13 18:02:00', 'Ушел в рабочей форме'),
(41, 'Ильин Никита Фёдорович', 'Руководящий состав', '1998-02-18', 'Генеральный секретарь', '+7(921)137-74-26', '2025-05-14 07:40:00', '2025-05-14 17:45:00', ''),
(64, 'Кузнецова Мария Сергеевна', 'Коммерческий отдел', '1999-11-08', 'Менеджер', '+7(927)499-57-49', '2025-05-15 09:30:00', '2025-05-15 13:03:00', ''),
(65, 'Кузнецова Мария Сергеевна', 'Коммерческий отдел', '1989-05-22', 'Менеджер', '+7(927)464-21-89', '2025-05-14 07:57:00', '2025-05-14 13:03:00', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitor_id` (`visitor_id`);

--
-- Индексы таблицы `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`visitor_id`) REFERENCES `visitors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
