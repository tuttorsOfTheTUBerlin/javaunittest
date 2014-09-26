class Search { //need to be non-public in order to allow several classes to be used in one JUnit-test-file
	public static int searchPosition(int[] where, int what) {
  		
		for(int i = 0; i < where.length; i++){
			if(where[i] == what) return i;
		}

		return -1;
	}
}

