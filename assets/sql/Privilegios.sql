# Privilegios para `Acceso`@`localhost`

GRANT USAGE ON *.* TO `Acceso`@`localhost` IDENTIFIED BY PASSWORD '*70F1B295EF939A5558DF20074E44316506D7AF05';

GRANT SELECT ON `Clinica`.`usuarios` TO `Acceso`@`localhost`;

GRANT SELECT, INSERT ON `Clinica`.`medicos` TO `Acceso`@`localhost`;


# Privilegios para `Administrador`@`localhost`

GRANT USAGE ON *.* TO `Administrador`@`localhost` IDENTIFIED BY PASSWORD '*08852B3AFBFB593750CB9DB4F2E27E60258928AF';

GRANT SELECT, INSERT ON `Clinica`.`medicos` TO `Administrador`@`localhost`;

GRANT SELECT, INSERT ON `Clinica`.`pacientes` TO `Administrador`@`localhost`;

GRANT SELECT, INSERT ON `Clinica`.`usuarios` TO `Administrador`@`localhost`;


# Privilegios para `Asistente`@`localhost`

GRANT USAGE ON *.* TO `Asistente`@`localhost` IDENTIFIED BY PASSWORD '*7D1BB3985F9CAC85224AAF18068F1C7FB6945700';

GRANT SELECT, INSERT ON `Clinica`.`usuarios` TO `Asistente`@`localhost`;

GRANT SELECT, INSERT ON `Clinica`.`citas` TO `Asistente`@`localhost`;

GRANT SELECT ON `Clinica`.`consultorios` TO `Asistente`@`localhost`;

GRANT SELECT, INSERT ON `Clinica`.`pacientes` TO `Asistente`@`localhost`;

GRANT SELECT ON `Clinica`.`medicos` TO `Asistente`@`localhost`;


# Privilegios para `Medico`@`localhost`

GRANT USAGE ON *.* TO `Medico`@`localhost` IDENTIFIED BY PASSWORD '*93D6C5C072CA9F67C548FF2D832B217C41A938D0';

GRANT SELECT ON `Clinica`.`pacientes` TO `Medico`@`localhost`;

GRANT SELECT ON `Clinica`.`medicos` TO `Medico`@`localhost`;

GRANT SELECT, INSERT, UPDATE ON `Clinica`.`citas` TO `Medico`@`localhost`;


# Privilegios para `Paciente`@`localhost`

GRANT USAGE ON *.* TO `Paciente`@`localhost` IDENTIFIED BY PASSWORD '*EC708025B9624D040B520FB1DC967660E160F559';

GRANT SELECT ON `Clinica`.`consultorios` TO `Paciente`@`localhost`;

GRANT SELECT ON `Clinica`.`citas` TO `Paciente`@`localhost`;

GRANT SELECT ON `Clinica`.`medicos` TO `Paciente`@`localhost`;