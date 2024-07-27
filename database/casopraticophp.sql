SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `consultas` (
  `user_id` int(20) NOT NULL,
  `id` int(11) NOT NULL,
  `data_consulta` date NOT NULL,
  `horario` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `consultas` (`user_id`, `id`, `data_consulta`, `horario`, `status`) VALUES
(3, 54, '2024-02-09', '10:00', 'agendada'),
(1, 58, '2024-01-27', '09:00', 'Agendada'),
(4, 64, '2024-01-17', '10:00', 'Agendada'),
(2, 65, '2024-01-05', '09:00', 'agendada'),
(1, 66, '2024-01-04', '10:00', 'Agendada');

CREATE TABLE `procedimentos` (
  `user_id` int(11) NOT NULL,
  `procedimento_id` int(11) NOT NULL,
  `procedimento_solicitado` varchar(20) NOT NULL,
  `procedimento_realizado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `procedimentos` (`user_id`, `procedimento_id`, `procedimento_solicitado`, `procedimento_realizado`) VALUES
(1, 5, 'Periodontia', 'Raspagem supra'),
(3, 10, 'Dentistica', 'Restauração no elemento 37'),
(4, 11, 'Periodontia', 'Raspagem supra'),
(1, 13, 'Periodontia', ''),
(4, 14, 'Endodontia', 'tratamento de canal do elemento 23');

CREATE TABLE `usuarios` (
  `user_id` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `apelido` varchar(20) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `user_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`user_id`, `nome`, `apelido`, `user_name`, `email`, `password`, `user_type`) VALUES
(1, 'taylor', 'swift', 'taylor', 'taylor.s@gmail.com', '4321', 'utilizador'),
(2, 'thais', 'lira', 'admin', 'thaislira@gmail.com', 'admin1234', 'administrador'),
(3, 'barackk', 'obama', 'barack', 'barack.@gmail.com', '7890', 'utilizador'),
(4, 'cristiano', 'ronaldo', 'cr7', 'criscr7@gmail.com', 'portugal', 'utilizador');


ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `procedimentos`
  ADD PRIMARY KEY (`procedimento_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`user_id`);


ALTER TABLE `consultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

ALTER TABLE `procedimentos`
  MODIFY `procedimento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `usuarios`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `consultas`
  ADD CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`user_id`);

ALTER TABLE `procedimentos`
  ADD CONSTRAINT `procedimentos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
