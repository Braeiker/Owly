API RESTful per Gestione Corsi e Materie

---

Introduzione:
Il progetto "API RESTful per Gestione Corsi e Materie" offre un set di API RESTful per la gestione di corsi e materie, implementate seguendo i principi dell'architettura REST. Le API consentono operazioni di inserimento, modifica, cancellazione e visualizzazione dei dati relativi ai corsi e alle materie.

---

Tecnologie Utilizzate:
- Linguaggio: PHP
- Database: MySQL
- Accesso al Database: PDO (PHP Data Objects)

---

Struttura del Database:
La struttura del database è definita nel file `migrations.sql`. Esso contiene le istruzioni necessarie per creare le tabelle `corsi` e `materie` con le relative colonne.

---

API disponibili:

Materie:
1. Inserimento di un Corso
   - Endpoint: http://127.0.0.1/Owly/api/create.php
   - Metodo: POST
   - Parametri Richiesti: `nome` (Nome del corso), `numeri_studenti` (Numero di posti disponibili)
   - Status Code di Risposta:
     - 201 Created: Successo
     - 400 Bad Request: Parametri non validi
     - 500 Internal Server Error: Errore interno del server

2. Modifica di un Corso
   - Endpoint: http://127.0.0.1/Owly/api/update.php
   - Metodo: PUT
   - Parametri Richiesti: `nome` (Nuovo nome del corso), `numeri_studenti` (Nuovo numero di posti disponibili)
   - Status Code di Risposta:
     - 200 OK: Successo
     - 400 Bad Request: Parametri non validi
     - 404 Not Found: Corso non trovato
     - 500 Internal Server Error: Errore interno del server

3. Cancellazione di un Corso
   - Endpoint: http://127.0.0.1/Owly/api/delete.php
   - Metodo: DELETE
   - Status Code di Risposta:
     - 204 No Content: Successo
     - 404 Not Found: Corso non trovato
     - 500 Internal Server Error: Errore interno del server

4. Visualizzazione di tutti i Corsi
   - Endpoint: http://127.0.0.1/Owly/api/read.php
   - Metodo: GET
   - Status Code di Risposta:
     - 200 OK: Successo
     - 500 Internal Server Error: Errore interno del server

5. Filtraggio dei Corsi
   - Endpoint: http://127.0.0.1/Owly/api/ricercaCorso.php
   - Metodo: POST
   - Parametri Richiesti: `filtroNome` (Nome del corso da filtrare), `filtroId` (Numero di posti disponibili da filtrare)
   - Status Code di Risposta:
     - 200 OK: Successo
     - 400 Bad Request: Parametri non validi
     - 500 Internal Server Error: Errore interno del server

---

Sicurezza e SQL Injection:
Tutte le query eseguite sul database utilizzano PDO per garantire la sicurezza e prevenire attacchi di tipo SQL Injection. Le variabili vengono opportunamente sanificate e validate prima di essere utilizzate nelle query.

---

Link al Repository su GitHub:
Per esplorare il codice sorgente completo, consultare la documentazione dettagliata e seguire gli sviluppi futuri, è possibile visitare il repository su GitHub: [Owly API Repository](inserisci-il-tuo-link-github)
