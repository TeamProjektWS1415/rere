
import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;

public class main {

    public static void main(String[] args) {
        String input = "";
        String output = "";
        input = readFile("C:\\Users\\Felix\\Desktop\\Gradeadministration\\Gradeadministration\\datenUndSchema\\tx_gradeadministration_subject.sql");
        output = prepareCSV(input);
        System.out.println(output);
    }

    private static String readFile(String pfad) {
        String text = "";
        try (BufferedReader br = new BufferedReader(new FileReader(pfad))) {
            String sCurrentLine;
            while ((sCurrentLine = br.readLine()) != null) {
                text += sCurrentLine + "\n";
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
        return text;
    }

    private static String prepareCSV(String input) {
        String output = "";
        int hochKommaZaehler = 0;
        for (char c : input.toCharArray()) {
            if (c == '\'') {
                hochKommaZaehler++;
            }
            if (hochKommaZaehler % 2 != 0) {
                output += c;
                continue;
            }

            if (c == ',') {
                output += '^';
                continue;
            }
            if (c == '(') {
                continue;
            }
            if (c == ')') {
                continue;
            }

            output += c;
        }
        return output;
    }

}
