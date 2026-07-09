/**
 * Outlandis Homes — Property listings from manufacturer catalog
 */
const OUTLANDIS_LISTINGS = {
  featured: [
    {
      id: "clayton-summit",
      name: "Clayton Summit",
      series: "Epic Experiences",
      brand: "Clayton",
      type: "manufactured",
      width: "triple",
      beds: 4,
      baths: 3,
      sqft: 2280,
      dimensions: "32'0\" x 76'0\"",
      description: "Spacious four-bedroom family home with premium finishes and open-concept living.",
      image: "assets/images/clayton-cover.webp",
      url: "https://www.claytonhomes.com/homes/30CEE32764AH/",
      featured: true
    },
    {
      id: "phoenix-augusta",
      name: "The Phoenix Augusta",
      series: "Phoenix",
      brand: "Cavco",
      type: "manufactured",
      width: "double",
      beds: 3,
      baths: 2,
      sqft: 1280,
      dimensions: "28'0\" x 48'0\"",
      description: "Modern Cavco design with durable construction and stylish open floor plans.",
      image: "assets/images/cavco-cover.webp",
      url: "https://www.cavcohomecenters.com/plan/233314-5559/cavco-home-center-of-lafayette/lafayette/phoenix/augusta-16562a/",
      featured: true
    },
    {
      id: "ironclad-3276",
      name: "Ironclad 32x76",
      series: "Ironclad",
      brand: "Champion",
      type: "manufactured",
      width: "double",
      beds: 4,
      baths: 2.5,
      sqft: 2305,
      dimensions: "32'0\" x 76'0\"",
      description: "Champion Ironclad series — innovative layouts with dependable craftsmanship.",
      image: "assets/images/champion-cover.webp",
      url: "https://www.championhomesofnc.com/home-plans-photos/ironclad-3276-21",
      featured: true
    },
    {
      id: "clayton-expedition",
      name: "Clayton Expedition",
      series: "Epic Experiences",
      brand: "Clayton",
      type: "manufactured",
      width: "double",
      beds: 4,
      baths: 2,
      sqft: 1580,
      dimensions: "28'0\" x 60'0\"",
      description: "Efficient, customizable floor plan designed for long-term value and comfort.",
      image: "assets/images/clayton-cover.webp",
      url: "https://www.claytonhomes.com/homes/45CEE28604AH/",
      featured: false
    },
    {
      id: "phoenix-66",
      name: "The Phoenix 66",
      series: "Phoenix",
      brand: "Cavco",
      type: "manufactured",
      width: "single",
      beds: 3,
      baths: 2,
      sqft: 1056,
      dimensions: "16'0\" x 66'0\"",
      description: "Compact single-section home with modern open-concept living at an affordable price.",
      image: "assets/images/cavco-cover.webp",
      url: "https://www.cavcohomecenters.com/plan/231423-5288/cavco-home-center-of-north-carolina/hamlet/phoenix/the-phoenix-66-16663a/",
      featured: false
    },
    {
      id: "prime-3276",
      name: "Prime 3276H42P03",
      series: "Prime",
      brand: "Champion",
      type: "manufactured",
      width: "double",
      beds: 4,
      baths: 2,
      sqft: 2432,
      dimensions: "32'0\" x 76'0\"",
      description: "Double-section Champion Prime with spacious bedrooms and contemporary design.",
      image: "assets/images/champion-cover.webp",
      url: "https://my.matterport.com/show/?play=1&m=1XkaEkEvkvg",
      featured: false
    }
  ],

  catalog: [
  // Cavco — Phoenix Series
  { id: "cav-1", name: "The Phoenix Augusta", series: "Phoenix", brand: "Cavco", width: "double", beds: 3, baths: 2, sqft: 1280, dimensions: "28'0\" x 48'0\"", url: "https://www.cavcohomecenters.com/plan/233314-5559/cavco-home-center-of-lafayette/lafayette/phoenix/augusta-16562a/", image: "assets/images/cavco-cover.webp" },
  { id: "cav-2", name: "The Phoenix 66", series: "Phoenix", brand: "Cavco", width: "single", beds: 3, baths: 2, sqft: 1056, dimensions: "16'0\" x 66'0\"", url: "https://www.cavcohomecenters.com/plan/231423-5288/cavco-home-center-of-north-carolina/hamlet/phoenix/the-phoenix-66-16663a/", image: "assets/images/cavco-cover.webp" },
  { id: "cav-3", name: "The Phoenix 76", series: "Phoenix", brand: "Cavco", width: "single", beds: 3, baths: 2, sqft: 1216, dimensions: "16'0\" x 76'0\"", url: "https://www.cavcohomecenters.com/plan/231424-5288/cavco-home-center-of-north-carolina/hamlet/phoenix/the-phoenix-76-16763a/", image: "assets/images/cavco-cover.webp" },
  { id: "cav-4", name: "Phoenix 32 x 48", series: "Phoenix", brand: "Cavco", width: "double", beds: 3, baths: 2, sqft: 1536, dimensions: "32'0\" x 48'0\"", url: "https://www.cavcohomecenters.com/plan/233903-3974/cavco-home-center-of-tifton/tifton/phoenix/32483a/", image: "assets/images/cavco-cover.webp" },
  { id: "cav-5", name: "Phoenix 32 x 56", series: "Phoenix", brand: "Cavco", width: "double", beds: 3, baths: 2, sqft: 1792, dimensions: "32'0\" x 56'0\"", url: "https://www.cavcohomecenters.com/plan/232358-3974/cavco-home-center-of-tifton/tifton/phoenix/the-phoenix-32563a/", image: "assets/images/cavco-cover.webp" },
  { id: "cav-6", name: "Phoenix 32 x 68", series: "Phoenix", brand: "Cavco", width: "double", beds: 4, baths: 2, sqft: 2176, dimensions: "32'0\" x 68'0\"", url: "https://www.cavcohomecenters.com/plan/232359-3974/cavco-home-center-of-tifton/tifton/phoenix/the-phoenix-32684a/", image: "assets/images/cavco-cover.webp" },

  // Clayton — Epic Experiences
  { id: "clay-ee-1", name: "Clayton Tide", series: "Epic Experiences", brand: "Clayton", width: "single", beds: 2, baths: 2, sqft: 1020, dimensions: "16'0\" x 66'0\"", url: "https://www.claytonhomes.com/homes/30CEE16682AH/", image: "assets/images/clayton-cover.webp" },
  { id: "clay-ee-2", name: "Clayton Mariner", series: "Epic Experiences", brand: "Clayton", width: "single", beds: 3, baths: 2, sqft: 1140, dimensions: "16'0\" x 76'0\"", url: "https://www.claytonhomes.com/homes/30CEE16763EH/", image: "assets/images/clayton-cover.webp" },
  { id: "clay-ee-3", name: "Clayton Voyage", series: "Epic Experiences", brand: "Clayton", width: "double", beds: 3, baths: 2, sqft: 1140, dimensions: "28'0\" x 76'0\"", url: "https://www.claytonhomes.com/homes/43CEE16763HH/", image: "assets/images/clayton-cover.webp" },
  { id: "clay-ee-4", name: "Clayton Explorer", series: "Epic Experiences", brand: "Clayton", width: "double", beds: 3, baths: 2, sqft: 1475, dimensions: "28'0\" x 56'0\"", url: "https://www.claytonhomes.com/homes/45CEE28563CH/", image: "assets/images/clayton-cover.webp" },
  { id: "clay-ee-5", name: "Clayton Expedition", series: "Epic Experiences", brand: "Clayton", width: "double", beds: 4, baths: 2, sqft: 1580, dimensions: "28'0\" x 60'0\"", url: "https://www.claytonhomes.com/homes/45CEE28604AH/", image: "assets/images/clayton-cover.webp" },
  { id: "clay-ee-6", name: "Clayton Snowcap", series: "Epic Experiences", brand: "Clayton", width: "double", beds: 4, baths: 3, sqft: 2001, dimensions: "28'0\" x 76'0\"", url: "https://www.claytonhomes.com/homes/45CEE28764BH/", image: "assets/images/clayton-cover.webp" },
  { id: "clay-ee-7", name: "Clayton Summit", series: "Epic Experiences", brand: "Clayton", width: "triple", beds: 4, baths: 3, sqft: 2280, dimensions: "32'0\" x 76'0\"", url: "https://www.claytonhomes.com/homes/30CEE32764AH/", image: "assets/images/clayton-cover.webp" },

  // Clayton — Epic Journey
  { id: "clay-ej-1", name: "Clayton Lewis", series: "Epic Journey", brand: "Clayton", width: "single", beds: 2, baths: 2, sqft: 840, dimensions: "16'0\" x 56'0\"", url: "https://www.claytonhomes.com/homes/30CEJ16562AH/", image: "assets/images/clayton-cover.webp" },
  { id: "clay-ej-2", name: "Clayton Clark", series: "Epic Journey", brand: "Clayton", width: "single", beds: 3, baths: 2, sqft: 990, dimensions: "16'0\" x 66'0\"", url: "https://www.claytonhomes.com/homes/30CEJ16663AH/", image: "assets/images/clayton-cover.webp" },
  { id: "clay-ej-3", name: "Clayton Boone", series: "Epic Journey", brand: "Clayton", width: "double", beds: 4, baths: 2, sqft: 1475, dimensions: "28'0\" x 56'0\"", url: "https://www.claytonhomes.com/homes/30CEJ28564AH/", image: "assets/images/clayton-cover.webp" },
  { id: "clay-ej-4", name: "Clayton Sevier", series: "Epic Journey", brand: "Clayton", width: "double", beds: 4, baths: 3, sqft: 2001, dimensions: "28'0\" x 76'0\"", url: "https://www.claytonhomes.com/homes/43CEJ28764AH/", image: "assets/images/clayton-cover.webp" },

  // Clayton — Ultra Pro Flex
  { id: "clay-upf-1", name: "Ultra Flex 48", series: "Ultra Pro Flex", brand: "Clayton", width: "double", beds: 3, baths: 2, sqft: 1264, dimensions: "28'0\" x 48'0\"", url: "https://www.claytonhomes.com/homes/29UPF28483AH/", image: "assets/images/clayton-cover.webp" },
  { id: "clay-upf-2", name: "Ultra Flex Big BOY", series: "Ultra Pro Flex", brand: "Clayton", width: "triple", beds: 4, baths: 2, sqft: 2280, dimensions: "32'0\" x 76'0\"", url: "https://www.claytonhomes.com/homes/29UPF32764AH/", image: "assets/images/clayton-cover.webp" },

  // Clayton — Horizon
  { id: "clay-hzr-1", name: "Clayton Atlas", series: "Horizon", brand: "Clayton", width: "single", beds: 2, baths: 2, sqft: 840, dimensions: "16'0\" x 60'0\"", url: "https://www.claytonhomes.com/homes/37HZR16602AH/", image: "assets/images/clayton-cover.webp" },
  { id: "clay-hzr-2", name: "Clayton Eclipse", series: "Horizon", brand: "Clayton", width: "double", beds: 4, baths: 2, sqft: 1859, dimensions: "28'0\" x 68'0\"", url: "https://www.claytonhomes.com/homes/37HZR28684AH/", image: "assets/images/clayton-cover.webp" },

  // Clayton — Buccaneer
  { id: "clay-buc-1", name: "The Walsh", series: "Buccaneer", brand: "Clayton", width: "single", beds: 3, baths: 2, sqft: 1140, dimensions: "16'0\" x 76'0\"", url: "https://www.claytonhomes.com/homes/73ADM16763BH/", image: "assets/images/clayton-cover.webp" },
  { id: "clay-buc-2", name: "The Carolina", series: "Buccaneer", brand: "Clayton", width: "triple", beds: 4, baths: 2, sqft: 2280, dimensions: "32'0\" x 76'0\"", url: "https://www.claytonhomes.com/homes/73ADM32764DH/", image: "assets/images/clayton-cover.webp" },
  { id: "clay-buc-3", name: "The Hewitt", series: "Buccaneer", brand: "Clayton", width: "triple", beds: 4, baths: 3, sqft: 2395, dimensions: "32'0\" x 84'0\"", url: "https://www.claytonhomes.com/homes/73ADM32844AH21/", image: "assets/images/clayton-cover.webp" },

  // Champion — Ironclad
  { id: "champ-ic-1", name: "Ironclad 16x76", series: "Ironclad", brand: "Champion", width: "single", beds: 3, baths: 2, sqft: 1152, dimensions: "16'0\" x 76'0\"", url: "https://www.championhomes.com/models/ironclad-1676", image: "assets/images/champion-cover.webp" },
  { id: "champ-ic-2", name: "Ironclad 28x56", series: "Ironclad", brand: "Champion", width: "double", beds: 3, baths: 2, sqft: 1493, dimensions: "28'0\" x 56'0\"", url: "https://www.championhomes.com/models/ironclad-2856-07", image: "assets/images/champion-cover.webp" },
  { id: "champ-ic-3", name: "Ironclad 32x76", series: "Ironclad", brand: "Champion", width: "double", beds: 4, baths: 2.5, sqft: 2305, dimensions: "32'0\" x 76'0\"", url: "https://www.championhomesofnc.com/home-plans-photos/ironclad-3276-21", image: "assets/images/champion-cover.webp" },

  // Champion — Prime
  { id: "champ-pr-1", name: "1466H32P01", series: "Prime", brand: "Champion", width: "single", beds: 3, baths: 2, sqft: 924, dimensions: "14'0\" x 66'0\"", url: "https://my.matterport.com/show/?play=1&m=Sq84QJ56wp6", image: "assets/images/champion-cover.webp" },
  { id: "champ-pr-2", name: "1676H32P01", series: "Prime", brand: "Champion", width: "single", beds: 3, baths: 2, sqft: 1216, dimensions: "16'0\" x 76'0\"", url: "https://my.matterport.com/show/?m=Bjrdkn7Ho1q", image: "assets/images/champion-cover.webp" },
  { id: "champ-pr-3", name: "2856H32P01", series: "Prime", brand: "Champion", width: "double", beds: 3, baths: 2, sqft: 1568, dimensions: "28'0\" x 56'0\"", url: "https://my.matterport.com/show/?m=YYGNMzKZEsa", image: "assets/images/champion-cover.webp" },
  { id: "champ-pr-4", name: "3276H42P03", series: "Prime", brand: "Champion", width: "double", beds: 4, baths: 2, sqft: 2432, dimensions: "32'0\" x 76'0\"", url: "https://my.matterport.com/show/?play=1&m=1XkaEkEvkvg", image: "assets/images/champion-cover.webp" },
  { id: "champ-pr-5", name: "3276H53P03", series: "Prime", brand: "Champion", width: "double", beds: 5, baths: 3, sqft: 2432, dimensions: "32'0\" x 76'0\"", url: "https://www.championhomes.com/models/mammoth", image: "assets/images/champion-cover.webp" },

  // Champion — Lake Manor
  { id: "champ-lm-1", name: "LKM-2856H32P01", series: "Lake Manor", brand: "Champion", width: "double", beds: 3, baths: 2, sqft: 1493, dimensions: "28'0\" x 56'0\"", url: "https://www.championhomes.com/models/lake-manor-2856h42383", image: "assets/images/champion-cover.webp" },
  { id: "champ-lm-2", name: "LKM-2876H53P01", series: "Lake Manor", brand: "Champion", width: "double", beds: 5, baths: 3, sqft: 2033, dimensions: "28'0\" x 76'0\"", url: "https://selectmobilehomes.com/floorplan/conestee/", image: "assets/images/champion-cover.webp" },

  // Champion — Altitude
  { id: "champ-alt-1", name: "Bremond", series: "Altitude", brand: "Champion", width: "double", beds: 3, baths: 2, sqft: 1699, dimensions: "32'0\" x 56'0\"", url: "https://fbhexpo.com/floorplan/bremond/", image: "assets/images/champion-cover.webp" },
  { id: "champ-alt-2", name: "Engelwood", series: "Altitude", brand: "Champion", width: "double", beds: 4, baths: 2, sqft: 1884, dimensions: "32'0\" x 60'0\"", url: "https://fbhexpo.com/floorplan/engelwood/", image: "assets/images/champion-cover.webp" }
  ]
};

if (typeof module !== 'undefined') module.exports = OUTLANDIS_LISTINGS;
