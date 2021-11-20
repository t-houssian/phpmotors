INSERT INTO clients
	(clientFirstname, clientLastname, clientEmail, clientPassword, comment)
VALUES
  ( 'Tony', 'Stark', 'tony@starkent.com', 'Iam1ronM@n', "I am the real Ironman" );

UPDATE clients SET clientLevel = '3' WHERE clientId = 2;

UPDATE inventory SET invDescription = replace(invDescription, 'small interior', 'spacious interior') WHERE invId = 12;

SELECT inventory.invModel, carclassification.classificationName
FROM inventory
INNER JOIN carclassification ON inventory.classificationId=carclassification.classificationId
WHERE carclassification.classificationId = 1;

DELETE FROM inventory WHERE invMake = 'Jeep' AND invModel = 'Wrangler';

UPDATE inventory SET invImage=CONCAT('/phpmotors', invImage), invThumbnail=CONCAT('/phpmotors', invThumbnail);

-- UPDATE inventory SET invImage = RIGHT(invImage, LENGTH(invImage) - 8)
-- UPDATE inventory SET invImage = RIGHT(invThumbnail, LENGTH(invThumbnail) - 8)

-- update inventory set invImage = substring(invImage, 5, len(YourField)-3);
-- UPDATE inventory SET invImage=CONCAT('/phpmotors/images/vehicles/', invImage), invThumbnail=CONCAT('/phpmotors/images/vehicles/', invThumbnail);