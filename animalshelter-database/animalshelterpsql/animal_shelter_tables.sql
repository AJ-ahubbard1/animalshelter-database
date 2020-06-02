/*
DELETE
RESTRICT
DELETE
CASCADE
NO ACTION.
*/
CREATE DATABASE animalshelter;
\c animalshelter;

CREATE TABLE IF NOT EXISTS location (
	location_id	BIGSERIAL PRIMARY KEY,
	street_no INT NOT NULL,
	street_name VARCHAR(50) NOT NULL,
	city VARCHAR(50) NOT NULL,
	state VARCHAR(3) NOT NULL,
	zip	INT NOT NULL,
	apt_no INT
);

CREATE TABLE IF NOT EXISTS shelter (
	shelter_id BIGSERIAL PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	phone VARCHAR(25) NOT NULL,
	max_housing INT NOT NULL,
	location_id BIGINT NOT NULL REFERENCES location(location_id),
	UNIQUE(location_id)
);

CREATE TABLE IF NOT EXISTS animal (
	animal_id BIGSERIAL PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	dob DATE NOT NULL,
	sex CHAR(1) NOT NULL,
	color VARCHAR(50) NOT NULL,
	breed VARCHAR(50) NOT NULL,
	species VARCHAR(32) NOT NULL,
	description VARCHAR(150),
	shelter_id BIGINT REFERENCES shelter(shelter_id)
);

CREATE TABLE IF NOT EXISTS medicalrecord (
	record_id BIGSERIAL PRIMARY KEY,
	rec_date DATE NOT NULL,
	weight NUMERIC NOT NULL,
	spayed_neutered boolean NOT NULL,
	condition VARCHAR(150),
	treatments VARCHAR(150),
	vaccinations VARCHAR(150),
	allergies VARCHAR(150),
	animal_id BIGINT NOT NULL REFERENCES animal(animal_id)
	);

CREATE TABLE IF NOT EXISTS specializedcare (
	care_id BIGSERIAL PRIMARY KEY,
	ctype VARCHAR(50) NOT NULL,
	description VARCHAR(150),
	amount INT NOT NULL,
	frequency INT NOT NULL,
	time_units VARCHAR(25) NOT NULL,
	animal_id BIGINT NOT NULL REFERENCES Animal(animal_id)
);

CREATE TABLE IF NOT EXISTS houses (
	shelter_id BIGINT NOT NULL REFERENCES Shelter(shelter_id),
	animal_id BIGINT NOT NULL REFERENCES Animal(animal_id),
	start_date DATE NOT NULL,
	end_date DATE,
	kennel_num SMALLINT NOT NULL,
	PRIMARY KEY(shelter_id, animal_id, start_date)
);

CREATE TABLE IF NOT EXISTS employee (
	employee_id BIGSERIAL PRIMARY KEY,
	ssn	INT NOT NULL,
	name VARCHAR(50) NOT NULL,
	home_phone VARCHAR(25) NOT NULL,
	cell_phone VARCHAR(25) NOT NULL,
	wage NUMERIC NOT NULL,
	position VARCHAR(25) NOT NULL,
	location_id BIGINT NOT NULL REFERENCES location(location_id)
);

CREATE TABLE IF NOT EXISTS timecard (
	timecard_id	BIGSERIAL PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	cur_date DATE NOT NULL,
	start_time Time NOT NULL,
	end_time Time NOT NULL,
	rate NUMERIC NOT NULL,
	employee_id	BIGINT NOT NULL REFERENCES employee(employee_id),
	shelter_id BIGINT NOT NULL REFERENCES shelter(shelter_id)
);

CREATE TABLE IF NOT EXISTS manages (
	manager_emp_id BIGINT REFERENCES employee(employee_id),
	shelter_id BIGINT REFERENCES shelter(shelter_id),
	start_date DATE NOT NULL,
	end_date DATE,
	PRIMARY KEY(manager_emp_id, shelter_id, start_date)
);

CREATE TABLE IF NOT EXISTS shelterwork (
	shelter_work_id	BIGSERIAL PRIMARY KEY,
	cur_date DATE NOT NULL,
	start_time time NOT NULL,
	end_time time NOT NULL,
	description	VARCHAR(50) NOT NULL,
	employee_id BIGINT NOT NULL REFERENCES employee(employee_id)
);

CREATE TABLE IF NOT EXISTS supply (
	supply_id BIGSERIAL PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	description	VARCHAR(50) NOT NULL,
	quantity INT NOT NULL
);

CREATE TABLE IF NOT EXISTS purchases (
	supply_id BIGINT NOT NULL REFERENCES supply(supply_id),	
	shelter_id BIGINT NOT NULL REFERENCES shelter(shelter_id),
	cur_date TIMESTAMP NOT NULL,
	quantity INT NOT NULL,
	price NUMERIC NOT NULL
);

CREATE TABLE IF NOT EXISTS supplyused (
	supply_id BIGINT NOT NULL REFERENCES supply(supply_id),
	shelter_work_id	BIGINT NOT NULL REFERENCES shelterwork(shelter_work_id),
	cur_date DATE NOT NULL,
	quantity INT NOT NULL
);

CREATE TABLE IF NOT EXISTS customer (
	customer_id	BIGSERIAL PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	home_phone VARCHAR(25) NOT NULL,
	cell_phone VARCHAR(25),
	drivers_license VARCHAR(15) NOT NULL, 
	location_id BIGINT NOT NULL REFERENCES location(location_id),
	UNIQUE(drivers_license)
);

CREATE TABLE IF NOT EXISTS donates (
	Customer_ID	BIGINT NOT NULL REFERENCES customer(customer_id),
	supply_id BIGINT NOT NULL REFERENCES supply(supply_id),
	cur_date date NOT NULL,
	quantity INT NOT NULL
);

CREATE TABLE IF NOT EXISTS adoptionrequest (
	animal_id BIGINT NOT NULL REFERENCES animal(animal_id),
	customer_id	BIGINT NOT NULL REFERENCES customer(customer_id),
	cur_date date NOT NULL,
	fee NUMERIC NOT NULL
);

CREATE TABLE IF NOT EXISTS transfer (
	transfer_id	BIGSERIAL PRIMARY KEY,
	cur_date date NOT NULL,
	reason VARCHAR(50) NOT NULL,
	current_location_id BIGINT NOT NULL REFERENCES location(location_id),
	new_location_id BIGINT NOT NULL REFERENCES location(location_id),
	animal_id BIGINT NOT NULL REFERENCES animal(animal_id)
);

CREATE TABLE IF NOT EXISTS adoption (
	adoption_id	BIGSERIAL PRIMARY KEY,
	approve_date date NOT NULL,
	approve_emp_id BIGINT NOT NULL REFERENCES employee(employee_id),
	ar_date	date NOT NULL,
	shelter_id BIGINT NOT NULL REFERENCES shelter(shelter_id),
	animal_id BIGINT NOT NULL REFERENCES animal(animal_id),
	customer_id BIGINT NOT NULL REFERENCES customer(customer_id),
	transfer_id BIGINT NOT NULL REFERENCES transfer(transfer_id)
);















