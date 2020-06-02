CREATE OR REPLACE FUNCTION ins_animal(_name VARCHAR, _dob DATE, _sex CHAR, _color VARCHAR, 
    _breed VARCHAR, _species VARCHAR, _description VARCHAR, _shelter_ID int) RETURNS void AS 
$$
    BEGIN	
        INSERT INTO animal (name, dob, sex, color, breed, species, description, shelter_id) 
        VALUES (_name, _dob, _sex, _color, _breed, _species, _description, _shelter_id);
    END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION ins_medicalrecord(_rec_date DATE, _weight NUMERIC, 
    _spayed_neutered BOOLEAN, _condition VARCHAR, _treatments VARCHAR, _vaccinations VARCHAR, 
    _allergies VARCHAR, _animal_id int) RETURNS void AS 
$$
    BEGIN
	   INSERT INTO medicalrecord (rec_date, weight, spayed_neutered, condition, treatments, 
            vaccinations, allergies, animal_id) 
       VALUES (_rec_date, _weight, _spayed_neutered, _condition, _treatments, 
            _vaccinations, _allergies, _animal_id);	
    END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION ins_specializedcare(_ctype VARCHAR, _description VARCHAR, _amount int, 
    _frequency int, _time_units VARCHAR, _animal_id int) RETURNS void AS 
$$
    BEGIN
        INSERT INTO specializedcare (ctype, description, amount, frequency, time_units, animal_id) 
        VALUES (_ctype, _description, _amount, _frequency, _time_units, _animal_id); 
    END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION ins_location(_street_no int, _street_name VARCHAR, _city VARCHAR, 
    _state VARCHAR, _zip int, _apt_no int) RETURNS void AS 
$$
    BEGIN
        INSERT INTO location (street_no, street_name, city, state, zip, apt_no) 
        VALUES (_street_no, _street_name, _city, _state, _zip, _apt_no); 
    END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION ins_employee(_ssn int, _name VARCHAR, _home_phone VARCHAR, 
    _cell_phone VARCHAR, _wage NUMERIC, _position VARCHAR, _location_id int) RETURNS void AS 
$$
    BEGIN
        INSERT INTO employee (ssn, name, home_phone, cell_phone, wage, position, location_id) 
        VALUES (_ssn, _name, _home_phone, _cell_phone, _wage, _position, _location_id); 
    END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION ins_timecard(_name VARCHAR, _cur_date DATE, _start_time TIME, 
    _end_time TIME, _rate NUMERIC, _employee_id int, _shelter_id int) RETURNS void AS 
$$
    BEGIN
        INSERT INTO timecard (name, cur_date, start_time, end_time, rate, employee_id, shelter_id) 
        VALUES (_name, _cur_date, _start_time, _end_time, _rate, _employee_id, _shelter_id); 
    END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION ins_purchase(_supply_id int, _shelter_id int, _cur_date TIMESTAMP, 
    _quantity int, _price NUMERIC) RETURNS void AS 
$$
    BEGIN
        INSERT INTO purchases (supply_id, shelter_id, cur_date, quantity, price) 
        VALUES (_supply_id, _shelter_id, _cur_date, _quantity, _price); 
    END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION del_animal(_animal_ID int) RETURNS void AS
$$
    BEGIN	
        DELETE FROM animal WHERE animal_id=_animal_ID;
    END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION del_specializedcare(_animal_ID int) RETURNS void AS
$$
    BEGIN   
        DELETE FROM specializedcare WHERE animal_id=_animal_ID;
    END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION del_medicalrecord(_animal_ID int) RETURNS void AS
$$
    BEGIN   
        DELETE FROM medicalrecord WHERE animal_id=_animal_ID;
    END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION ave_weight() 
	RETURNS TABLE (
		wt numeric
)
AS $$
BEGIN
    	RETURN QUERY SELECT ROUND(AVG(weight),2) FROM medicalrecord; 
END;
$$ LANGUAGE plpgsql;


CREATE VIEW animal_main AS SELECT animal_id, animal.name, dob, sex, species, breed, 
    animal.shelter_id AS shelter_id, shelter.name AS shelter 
    FROM animal LEFT JOIN shelter ON animal.shelter_id=shelter.shelter_id;

CREATE VIEW purchases_main AS SELECT supply.name, shelter.name AS shelter, cur_date, purchases.quantity, price FROM purchases 
    LEFT JOIN shelter ON purchases.shelter_id=shelter.shelter_id LEFT JOIN supply ON purchases.supply_id = supply.supply_id;

CREATE VIEW purchases_report AS SELECT name "items", SUM(price) "total_cost" FROM purchases_main GROUP BY name;

CREATE VIEW supply_report AS SELECT name, quantity FROM supply;

CREATE VIEW employees_earnings AS SELECT tc.name, tc.cur_date, tc.start_time, tc.end_time, (tc.end_time-tc.start_time) "time_worked", 
    tc.rate, e.wage, 
    round ( CAST (float8 (e.wage * tc.rate * (extract(HOUR FROM (tc.end_time-tc.start_time) ) ) ) + 
            (e.wage * tc.rate * (extract(MIN FROM (tc.end_time-tc.start_time) )/60) ) AS numeric) , 2 )
     "daily_earnings", tc.shelter_id FROM timecard tc left join employee e on tc.name=e.name ORDER BY tc.cur_date;

CREATE VIEW total_earnings AS SELECT SUM(daily_earnings) "Total Earnings" FROM employees_earnings;


