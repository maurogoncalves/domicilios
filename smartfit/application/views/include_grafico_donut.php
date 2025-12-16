segmentShowStroke: true,
segmentStrokeColor: "#fff",
segmentStrokeWidth: 4,
percentageInnerCutout: 45, // This is 0 for Pie charts
animationSteps: 100,
animationEasing: "easeOutBounce",
animateRotate: true,
animateScale: false,
responsive: true,
tooltipFontSize: 11,
tooltipFontFamily: "'Trebuchet MS', 'Helvetica', 'Arial', sans-serif",
maintainAspectRatio : false,
legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"