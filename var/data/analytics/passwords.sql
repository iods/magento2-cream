# Admin Password
SET @email='email@provedor', @passwd='NOVASENHA', @salt=MD5(RAND());

UPDATE admin_user
    SET password = CONCAT(SHA2(CONCAT(@salt, @passwd), 256), ':', @salt, ':1')
    WHERE email = @email;

# Customer Password
SET @email='email@provedor', @passwd='NOVASENHA', @salt=MD5(RAND());

UPDATE customer_entity
    SET password_hash = CONCAT(SHA2(CONCAT(@salt, @passwd), 256), ':', @salt, ':1')
    WHERE email = @email;