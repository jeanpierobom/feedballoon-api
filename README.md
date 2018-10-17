# feedballoon-api

SELECT
  f.id,
  f.from_user_id,
  CONCAT(user_from.firstname, ' ', user_from.lastname) AS user_from_name,
  f.to_user_id,
  CONCAT(user_to.firstname, ' ', user_to.lastname) AS user_to_name,
  f.message,
  f.date
FROM feedback AS f
INNER JOIN users AS user_from ON user_from.id = f.from_user_id
INNER JOIN users AS user_to ON user_to.id = f.to_user_id
ORDER BY date DESC
