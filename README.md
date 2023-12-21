# KOMENDY
### php bin/console app:fetchPosts -- pobiera posty z https://jsonplaceholder.typicode.com/ i zapisuje je w bazie danych w relacji z uzytkownikami
### php bin/console app:createAdmin email haslo -- tworzy konto administratora
# HTTP
### GET /posts -- zwraca JSON z postami {id, first_name, last_name, title, body}
### GET /list -- widok wszystkich postów z możliwością usunięcia ich(wymaga bycia zalogowanym na konto administratora)
### GET /login -- panel logowania
