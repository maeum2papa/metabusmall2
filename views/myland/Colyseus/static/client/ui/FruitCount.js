class FruitCount {
   count;

   constructor(context, count) {
      if (count === undefined) {
         count = 0;
      }
      this.count = count;
      // fruitCount.innerText = this.count;
   }

   countUpdate() {
      // fruitCount.innerText = this.count;
   }
}