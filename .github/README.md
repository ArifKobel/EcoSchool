# GitHub Actions CI/CD

## Tests Pipeline

Die Pipeline läuft automatisch bei:
- Push auf `main` Branch
- Pull Requests gegen `main` Branch

### Was macht die Pipeline:
1. **Code auschecken** - Repository klonen
2. **PHP 8.2 einrichten** - Mit SQLite Extension
3. **Dependencies installieren** - Composer packages
4. **Umgebung konfigurieren** - .env Datei erstellen
5. **Application Key generieren** - Laravel App Key
6. **Datenbank erstellen** - SQLite Datenbank
7. **Migrationen ausführen** - Datenbankschema aufbauen
8. **Tests ausführen** - Alle PHPUnit Tests

### Test-Ergebnisse:
- ✅ 7 Tests laufen erfolgreich
- ✅ 21 Assertions werden geprüft
- ✅ Dauer: ~1.8 Sekunden

### Test-Abdeckung:
- **Unit Tests**: Question, Result, Category Modelle
- **Integration Tests**: Questionnaire Workflow (Validierung, Authentifizierung, API)
