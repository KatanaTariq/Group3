/********************************
Developer: KATANA
University ID: 201995570
Function: Math utility functions for Team Project.
********************************/
public class Math {

    /********************************
    
    Function: Adds two integers and returns the sum.
    ********************************/
    public static int Add(int x, int y) {
        return x + y;
    }

    /********************************
<<<<<<< HEAD
    Developer: (Rehana Ria)
    University ID: (240366050)
=======
    Developer: (Haroon Mohammed)
    University ID: (240109826)
>>>>>>> b680ae074375190c35160c2c95a220b106e9bb21
    Function: Returns the larger of two integers.
    ********************************/
    public static int Max(int a, int b) {
        return (a > b) ? a : b;
    }

    // ——— Stubs for other teammates to fill ———
    public static int Min(int a, int b) 
    { return (a < b) ? a : b; }
    public static int Sub(int a, int b) { return a - b; }
    public static int Multi(int a, int b) { return a * b; }

    public static int Divide(int a, int b) {
        // Basic guard (optional)
        if (b == 0) throw new ArithmeticException("Divide by zero");
        return a / b;
    }

    public static int Power(int base, int exp) {
        int result = 1;
        for (int i = 0; i < exp; i++) result *= base;
        return result;
    }

    public static int Mod(int a, int b) {
        if (b == 0) throw new ArithmeticException("Mod by zero");
        return a % b;
    }
}
