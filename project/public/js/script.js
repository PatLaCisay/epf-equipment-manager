// custom js
const checkbox = document.getElementById("switcher");
const contentDisponible = document.getElementById("disponible");
const contentReserve = document.getElementById("reserve");

checkbox.addEventListener("change", function() {
  if (checkbox.checked) {
    console.log("Disponible");
    contentDisponible.style.display = "flex";
    contentReserve.style.display = "none";

  } else {
    console.log("Reservé");
    contentDisponible.style.display = "none";
    contentReserve.style.display = "flex";
  }
});

function itemsGraph(dataSet){
  const ctx = document.getElementById("items_graph");
  let chartColor=[];  
  let values=[];
  let datas = JSON.parse(dataSet);
  let labels=[];
    
  datas.forEach(data => {
          labels.push(data["category"]);
          values.push(data["quantity"]);
          chartColor.push(getRandomColor());
      }
  ); 

  const dataset = {
    labels: labels,
    datasets: [
      {
        data: values,
        backgroundColor: chartColor,
      }
    ]
  };

    const config = new Chart(ctx, {
        type: 'doughnut',
        data: dataset,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            size: 22
                        }
                    }
                }
            }
        },
    });
}

function getRandomColor() {
    var red = Math.floor(Math.random() * 256);   // Random value between 0 and 255 for red
    var green = Math.floor(Math.random() * 256); // Random value between 0 and 255 for green
    var blue = Math.floor(Math.random() * 256);  // Random value between 0 and 255 for blue
    if (red < 100 && green < 100 && blue < 100) {
        var maxChannel = Math.max(red, green, blue);
        var randomOffset = Math.floor(Math.random() * (256 - maxChannel));
        red += randomOffset;
        green += randomOffset;
        blue += randomOffset;
    }
    return "rgb(" + red + ", " + green + ", " + blue + ")";
  }