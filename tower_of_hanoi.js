//円盤の枚数
let n = 20
console.log("今回の円盤の枚数は" + n + "枚です");

// 各棒を用意(目標は棒aから棒bに全ての円盤を移すこと)
let a = []
let b = []
let c = []

// 棒aにn枚の円盤を用意
for (let i = n; i >= 1; --i){
  a.push(i)
}

// 初期設定(0手目)
console.log("*0手目");
console.log("a:[" + a + "]");
console.log("b:[" + b + "]");
console.log("c:[" + c + "]");

//メソッド(棒aの最上段にある円盤を棒bに移動させる)
function moveDisk(a, b){

  // 動かすことが可能な円板(棒aの最上段にある円盤)
  let a_top = a[a.length-1]

  a.pop()
  b.push(a_top)
}

// function(n個の円板をfromからtoに移動させる)
let count = 0

function hanoi(n,from,to,remain){
  
  if(n == 0){

    return;

  }else{
    //n-1個の円盤をfromからremainに移動させる
    hanoi(n - 1,from,remain,to);
    //最下段の1つをfromからtoへ移動させる
    moveDisk(from,to);
    //手数のカウント
    count++;
    console.log("*" + count + "手目");
    //各手数での棒の状況
    console.log("a:[" + a + "]");
    console.log("b:[" + b + "]");
    console.log("c:[" + c + "]");
    //n-1をremainからtoへ移動させる
    hanoi(n - 1,remain,to,from);

  }
}

//n枚の円盤を棒aからbに移すメソッド(以下の①~③の繰り返し処理)
//①n-1個の円盤をaからcに移動させる
//②最下段の1つをaからbへ移動させる
//③n-1をcからbへ移動させる
hanoi(n,a,b,c)

//手数の出力
console.log("合計手数")
console.log(count)