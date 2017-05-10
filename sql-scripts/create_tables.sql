DROP  SCHEMA public;
CREATE SCHEMA public;

CREATE TABLE public.section (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(128)
);

CREATE TABLE public.item (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fk_section_id INT NOT NULL,
  title VARCHAR(256),
  description VARCHAR(1024),
  INDEX id_index (id),
  FOREIGN KEY (fk_section_id)
    REFERENCES section(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE public.image (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fk_item_id INT,
  path VARCHAR(256),
  data BLOB,
  INDEX id_index (id),
  FOREIGN KEY (fk_item_id)
    REFERENCES item(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);