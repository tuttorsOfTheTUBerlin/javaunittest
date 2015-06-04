class Factorial { //need to be non-public in order to allow several classes to be used in one JUnit-test-file
    public static double factorial(int i) {
        if (i==0) return 1.0;
        //if (i==1) return 2.0;    //uncomment to get execution failure
        return i * factorial(i-1); // remove e.g. the ';' to get compilation failure
    }
}