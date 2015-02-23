Die beiden Scripte Import 1.0 und Import 2.0 unterscheiden sich dahingehend, dass Import 2.0 mit den Klausurzeitpunkten(falls dieses nicht vorhanden sind mit den Erstellungszeitpunkten der Datensätze) versucht die Daten in unser semesterbasiertes Schema zu bringen. Dies kann aufgrund mangelnder Daten eventuell Fächer+Module im falschen Intervall anzeigen lassen. Import 1.0 macht aus sämtlichen vorhandenen Prüfungen eines Faches eine große Prüfung. Es muss NUR EINS der beiden Scripte ausgeführt werden. 
Die Daten müssen in 4 CSV-Dateien vorliegen:
Administrations.csv
Subjects.csv
Grades.csv
Modules.csv

Zur Vorbereitung der CSV Daten kann das JavaProgramm CVS_Parser benutzt werden. 
Vorsicht! In den Beispieldaten befanden sich mitten zwischen den Datensätzen insert Statements. Diese müssen mit einem Editor entfernt werden, dabei ist zu beachten, dass das vorhergehende Semikolon durch ein Komma ersetzt werden muss. Außerdem darf sich am Ende des CSV Datei kein Delimiter befinden. Also Delimiter bietet sich ‘^’ aufgrund des Nichtvorhandenseins in den Kommentaren an.

Beide Scripte sind nur im Browser richtig lauffähig und sollten nicht auf der Konsole ausgeführt werden. Außerdem befinden sich einige Einstellungen in den Scripten. Diese sollten vor der Ausführung geprüft werden.