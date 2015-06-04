class Reverse { // need to be non-public in order to allow several classes to be used in one JUnit-test-file
    public static String reverse(String str) {
        int i, len = str.length();
        StringBuffer dest = new StringBuffer(len);

        for (i = (len - 1); i >= 0; i--) {
            dest.append(str.charAt(i));
        }
        return dest.toString();
    }
}