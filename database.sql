CREATE TABLE proprietarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    telefone VARCHAR(20),
    endereco TEXT
);

CREATE TABLE pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50),
    raca VARCHAR(50),
    especie VARCHAR(50),
    dataNascimento DATE,
    proprietario_id INT,
    FOREIGN KEY (proprietario_id) REFERENCES proprietarios(id)
);

CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data DATE,
    hora TIME,
    motivo TEXT,
    pet_id INT,
    FOREIGN KEY (pet_id) REFERENCES pets(id)
);