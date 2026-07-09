#!/usr/bin/env python3
"""Generate listings-data.js from Outlandis Homes PDF catalog."""
import json
import re

def slugify(text):
    s = text.lower().strip()
    s = re.sub(r"[^a-z0-9]+", "-", s)
    return s.strip("-")

def listing(name, series, brand, beds, baths, sqft, dimensions, external_url=None,
            tour_url=None, notes="", featured=False, section=None):
    if section is None:
        w = dimensions.split("x")[0].replace("'", "").strip() if "x" in dimensions.lower() else ""
        try:
            wf = int(re.sub(r"[^\d]", "", w.split()[0] if w else "16") or 16)
            section = "single" if wf < 20 else ("triple" if wf >= 32 else "double")
        except Exception:
            section = "double"
    img = {
        "Cavco": "assets/images/cavco-cover.webp",
        "Clayton": "assets/images/clayton-cover.webp",
        "Champion": "assets/images/champion-cover.webp",
    }.get(brand, "assets/images/home-exterior.jpg")
    lid = slugify(f"{brand}-{name}")
    return {
        "id": lid,
        "slug": lid,
        "name": name,
        "series": series,
        "brand": brand,
        "manufacturer": f"{brand} Homes" if brand != "Cavco" else "Cavco",
        "beds": beds,
        "baths": baths,
        "sqft": sqft,
        "dimensions": dimensions,
        "section": section,
        "externalUrl": external_url or "",
        "tourUrl": tour_url or "",
        "notes": notes,
        "featured": featured,
        "has3dTour": bool(tour_url and "matterport" in tour_url.lower()),
        "image": img,
        "type": "manufactured",
    }

LISTINGS = []

# ── Cavco Phoenix ──
cavco_phoenix = [
    ("The Phoenix Augusta", 3, 2, 1280, "28'0\" x 48'0\"", "https://www.cavcohomecenters.com/plan/233314-5559/cavco-home-center-of-lafayette/lafayette/phoenix/augusta-16562a/"),
    ("The Phoenix 66", 3, 2, 1056, "16'0\" x 66'0\"", "https://www.cavcohomecenters.com/plan/231423-5288/cavco-home-center-of-north-carolina/hamlet/phoenix/the-phoenix-66-16663a/"),
    ("The Phoenix 76", 3, 2, 1216, "16'0\" x 76'0\"", "https://www.cavcohomecenters.com/plan/231424-5288/cavco-home-center-of-north-carolina/hamlet/phoenix/the-phoenix-76-16763a/"),
    ("Phoenix 32 x 48", 3, 2, 1536, "32'0\" x 48'0\"", "https://www.cavcohomecenters.com/plan/233903-3974/cavco-home-center-of-tifton/tifton/phoenix/32483a/"),
    ("Phoenix 32 x 56", 3, 2, 1792, "32'0\" x 56'0\"", "https://www.cavcohomecenters.com/plan/232358-3974/cavco-home-center-of-tifton/tifton/phoenix/the-phoenix-32563a/"),
    ("Phoenix 32 x 68", 4, 2, 2176, "32'0\" x 68'0\"", "https://www.cavcohomecenters.com/plan/232359-3974/cavco-home-center-of-tifton/tifton/phoenix/the-phoenix-32684a/"),
]
for i, (n, b, ba, sq, dim, url) in enumerate(cavco_phoenix):
    LISTINGS.append(listing(n, "Phoenix", "Cavco", b, ba, sq, dim, url, featured=(i < 2)))

# ── Clayton Epic Experiences ──
clay_ee = [
    ("Clayton Tide", 2, 2, 1020, "16'0\" x 66'0\"", "https://www.claytonhomes.com/homes/30CEE16682AH/"),
    ("Clayton Mariner", 3, 2, 1140, "16'0\" x 76'0\"", "https://www.claytonhomes.com/homes/30CEE16763EH/"),
    ("Clayton Voyage", 3, 2, 1140, "28'0\" x 76'0\"", "https://www.claytonhomes.com/homes/43CEE16763HH/"),
    ("Clayton Explorer", 3, 2, 1475, "28'0\" x 56'0\"", "https://www.claytonhomes.com/homes/45CEE28563CH/"),
    ("Clayton Expedition", 4, 2, 1580, "28'0\" x 60'0\"", "https://www.claytonhomes.com/homes/45CEE28604AH/"),
    ("Clayton Snowcap", 4, 3, 2001, "28'0\" x 76'0\"", "https://www.claytonhomes.com/homes/45CEE28764BH/"),
    ("Clayton Summit", 4, 3, 2280, "32'0\" x 76'0\"", "https://www.claytonhomes.com/homes/30CEE32764AH/"),
]
for i, row in enumerate(clay_ee):
    LISTINGS.append(listing(row[0], "Epic Experiences", "Clayton", row[1], row[2], row[3], row[4], row[5], featured=(row[0]=="Clayton Summit")))

# ── Clayton Epic Journey ──
clay_ej = [
    ("Clayton Lewis", 2, 2, 840, "16'0\" x 56'0\"", "https://www.claytonhomes.com/homes/30CEJ16562AH/"),
    ("Clayton Clark", 3, 2, 990, "16'0\" x 66'0\"", "https://www.claytonhomes.com/homes/30CEJ16663AH/"),
    ("Clayton Drake", 3, 2, 1052, "28'0\" x 40'0\"", "https://www.claytonhomes.com/homes/30CEJ28403AH/"),
    ("Clayton Mallegan", 3, 2, 1080, "16'0\" x 72'0\"", "https://www.claytonhomes.com/homes/30CEJ16723AH/"),
    ("Clayton Hudson", 3, 2, 1191, "28'0\" x 76'0\"", "https://www.claytonhomes.com/homes/56CEJ16763AH/"),
    ("Clayton Desoto", 3, 2, 1264, "28'0\" x 48'0\"", "https://www.claytonhomes.com/homes/30CEJ28483AH/"),
    ("Clayton Cook", 3, 2, 1369, "28'0\" x 52'0\"", "https://www.claytonhomes.com/homes/43CEJ28523AH/"),
    ("Clayton Boone", 4, 2, 1475, "28'0\" x 56'0\"", "https://www.claytonhomes.com/homes/30CEJ28564AH/"),
    ("Clayton Crockett", 3, 2, 1904, "28'0\" x 68'0\"", "https://www.claytonhomes.com/homes/43CEJ28683AH/"),
    ("Clayton Sevier", 4, 3, 2001, "28'0\" x 76'0\"", "https://www.claytonhomes.com/homes/43CEJ28764AH/"),
]
for row in clay_ej:
    LISTINGS.append(listing(row[0], "Epic Journey", "Clayton", row[1], row[2], row[3], row[4], row[5]))

# ── Clayton Ultra Pro Flex ──
clay_upf = [
    ("Ultra Flex 48", 3, 2, 1264, "28'0\" x 48'0\"", "https://www.claytonhomes.com/homes/29UPF28483AH/"),
    ("Ultra Flex 52", 3, 2, 1369, "28'0\" x 52'0\"", "https://www.claytonhomes.com/homes/29UPF28523AH/"),
    ("Ultra Flex 56 3", 3, 2, 1474, "28'0\" x 56'0\"", None, "Contact us for more information"),
    ("Ultra Flex 56 4", 4, 2, 1475, "28'0\" x 56'0\"", "https://www.claytonhomes.com/homes/29UPF28564AH/"),
    ("Ultra Flex 60", 3, 2, 1580, "28'0\" x 60'0\"", "https://www.claytonhomes.com/homes/29UPF28603AH/"),
    ("Ultra Flex 68", 4, 2, 1790, "28'0\" x 68'0\"", "https://www.claytonhomes.com/homes/29UPF28684AH/"),
    ("Ultra Flex Jewel", 3, 2, 1800, "32'0\" x 60'0\"", "https://www.claytonhomes.com/homes/29UPF32603AH/"),
    ("Ultra Flex 78", 4, 2, 2001, "28'0\" x 76'0\"", "https://www.claytonhomes.com/homes/29UPF28764AH/"),
    ("Ultra Flex Big BOY", 4, 2, 2280, "32'0\" x 76'0\"", "https://www.claytonhomes.com/homes/29UPF32764AH/"),
]
for row in clay_upf:
    LISTINGS.append(listing(row[0], "Ultra Pro Flex", "Clayton", row[1], row[2], row[3], row[4], row[5], notes=(row[6] if len(row) > 6 else "")))

# ── Clayton Horizon ──
clay_hz = [
    ("Clayton Atlas", 2, 2, 840, "16'0\" x 60'0\"", "https://www.claytonhomes.com/homes/37HZR16602AH/"),
    ("Clayton Oasis", 3, 2, 1080, "16'0\" x 72'0\"", "https://www.claytonhomes.com/homes/22HZR16723AH/"),
    ("Clayton Northstar", 3, 2, 1190, "28'0\" x 76'0\"", "https://www.claytonhomes.com/homes/22HZN16763AH/"),
    ("Clayton Vista", 3, 2, 1264, "28'0\" x 48'0\"", "https://www.claytonhomes.com/homes/38HZN28483AH/"),
    ("Clayton Aspire", 3, 2, 1475, "28'0\" x 56'0\"", "https://www.claytonhomes.com/homes/38HZN28563AH/"),
    ("Clayton Element", 3, 2, 1530, "28'0\" x 56'0\"", "https://www.claytonhomes.com/homes/37HZR28563AH/"),
    ("Clayton Haven", 3, 2, 1580, "28'0\" x 60'0\"", "https://www.claytonhomes.com/homes/34HZN28603AH/"),
    ("Clayton Eclipse", 4, 2, 1859, "28'0\" x 68'0\"", "https://www.claytonhomes.com/homes/37HZR28684AH/"),
]
for row in clay_hz:
    LISTINGS.append(listing(row[0], "Horizon", "Clayton", row[1], row[2], row[3], row[4], row[5]))

# ── Clayton Ultra Pro ──
for row in [
    ("Ultra A-Plus 16x76", 3, 2, 1140, "16'0\" x 76'0\"", "https://www.claytonhomes.com/homes/29UXL16763PH/"),
    ("Ultra Island Breeze 56", 3, 2, 1475, "28'0\" x 56'0\"", "https://www.claytonhomes.com/homes/29UXL28563IH/"),
    ("Ultra PRO Hercules", 3, 2, 1790, "28'0\" x 68'0\"", "https://www.claytonhomes.com/homes/29UXL28683AH/"),
]:
    LISTINGS.append(listing(row[0], "Ultra Pro", "Clayton", row[1], row[2], row[3], row[4], row[5]))

# ── Clayton Buccaneer ──
buccaneer = [
    ("The Walsh", 3, 2, 1140, "16'0\" x 76'0\"", "https://www.claytonhomes.com/homes/73ADM16763BH/"),
    ("The Bexar", 3, 2, 1170, "16'0\" x 78'0\"", "https://www.claytonhomes.com/homes/73ADM16783AH/"),
    ("The Halsey", 3, 2, 1170, "16'0\" x 78'0\"", "https://www.claytonhomes.com/homes/73ADM16783CH/"),
    ("The Marion", 3, 2, 1170, "16'0\" x 78'0\"", "https://www.claytonhomes.com/homes/73ADM16783BH/"),
    ("The Dewey", 3, 2, 1260, "16'0\" x 84'0\"", "https://www.claytonhomes.com/homes/73ADM16843AH/"),
    ("The Bobby Jo", 3, 2, 1260, "16'0\" x 84'0\"", "https://www.claytonhomes.com/homes/73AFH16843AH/"),
    ("The Mercer", 3, 2, 1260, "16'0\" x 84'0\"", "https://www.claytonhomes.com/homes/73ADM16843CH/"),
    ("The Jefferson", 3, 2, 1493, "28'0\" x 56'0\"", "https://www.claytonhomes.com/homes/73ADM28563HH/"),
    ("The Stark", 3, 2, 1493, "28'0\" x 56'0\"", "https://www.claytonhomes.com/homes/73ADM28563AH/"),
    ("The Avalyn", 3, 2, 1600, "28'0\" x 60'0\"", "https://www.claytonhomes.com/homes/73AFH28603AH/"),
    ("The Lulamae", 3, 2, 1832, "32'0\" x 66'0\"", "https://www.claytonhomes.com/homes/73AFH32663AH/"),
    ("The Turner", 3, 2, 1895, "32'0\" x 66'0\"", "https://www.claytonhomes.com/homes/73ADM32663AH/"),
    ("The Liza Jane", 3, 2, 1860, "32'0\" x 62'0\"", "https://www.claytonhomes.com/homes/73AFH32623AH/"),
    ("The Anna Fae", 3, 2, 1860, "32'0\" x 62'0\"", "https://www.claytonhomes.com/homes/73AFH32623BH/"),
    ("The Reed", 3, 2, 1920, "32'0\" x 64'0\"", "https://www.claytonhomes.com/homes/73ADM32643AH/"),
    ("The Mill House", 3, 2, 1962, "32'0\" x 68'0\"", "https://www.claytonhomes.com/homes/73ADM32683AH/"),
    ("The Ingram", 3, 2, 2040, "32'0\" x 68'0\"", "https://www.claytonhomes.com/homes/73ADM32683CH/"),
    ("The Lulabelle", 4, 2, 2132, "32'0\" x 76'0\"", "https://www.claytonhomes.com/homes/73AFH32764AH/"),
    ("The Arabella", 3, 2, 2160, "32'0\" x 72'0\"", "https://www.claytonhomes.com/homes/73AFH32723BH/"),
    ("The Tyra II", 4, 2, 2160, "32'0\" x 72'0\"", "https://www.claytonhomes.com/homes/73ADM32724AH/"),
    ("The Emma Jean", 4, 3, 2160, "32'0\" x 72'0\"", "https://www.claytonhomes.com/homes/73AFH32724AH/"),
    ("The Leahy", 4, 2, 2280, "32'0\" x 76'0\"", "https://www.claytonhomes.com/homes/73ADM32764CH/"),
    ("The Roddy", 4, 3, 2280, "32'0\" x 76'0\"", "https://www.claytonhomes.com/homes/73ADM32764BH/"),
    ("The Carolina", 4, 2, 2280, "32'0\" x 76'0\"", "https://www.claytonhomes.com/homes/73ADM32764DH/"),
    ("The Hewitt", 4, 3, 2395, "32'0\" x 84'0\"", "https://www.claytonhomes.com/homes/73ADM32844AH21/"),
    ("The Rocking Chair", 3, 2, 2400, "32'0\" x 80'0\"", "https://www.claytonhomes.com/homes/73AFH32803AH/"),
    ("The Magnolia", 3, 2, 1001, "14'0\" x 76'0\"", "https://www.claytonhomes.com/homes/36TRT14763MH/"),
]
for row in buccaneer:
    LISTINGS.append(listing(row[0], "Buccaneer", "Clayton", row[1], row[2], row[3], row[4], row[5]))

# ── Champion Ironclad ──
ironclad = [
    ("Ironclad 16x76", 3, 2, 1152, "16'0\" x 76'0\"", "https://www.championhomes.com/models/ironclad-1676"),
    ("Ironclad 28x48", 3, 2, 1280, "28'0\" x 48'0\"", "https://www.championhomes.com/models/ironclad-2848-09"),
    ("Ironclad 28x52", 3, 2, 1387, "28'0\" x 52'0\"", "https://www.championhomes.com/models/ironclad-2852-04"),
    ("Ironclad 28x56 07", 3, 2, 1493, "28'0\" x 56'0\"", "https://www.championhomes.com/models/ironclad-2856-07"),
    ("Ironclad 28x56 08", 3, 2, 1493, "28'0\" x 56'0\"", "https://www.championhomes.com/models/ironclad-2856-08"),
    ("Ironclad 28x56 09", 3, 2, 1493, "28'0\" x 56'0\"", "https://www.championhomes.com/models/ironclad-2856-09"),
    ("Ironclad 28x60 12", 4, 2, 1600, "28'0\" x 60'0\"", "https://www.championhomes.com/models/ironclad-2860-12"),
    ("Ironclad 28x64 05", 4, 2, 1707, "28'0\" x 64'0\"", "https://www.championhomes.com/models/ironclad-2864-05"),
    ("Ironclad 28x68 07", 3, 2, 1813, "28'0\" x 68'0\"", "https://www.championhomes.com/models/ironclad-2868-07/configure?v=4&s=0:0,1:0,2:0,3:0"),
    ("Ironclad 28x76 09", 4, 2, 2027, "28'0\" x 76'0\"", "https://www.championhomes.com/models/ironclad-2876-09"),
    ("Ironclad 32x56 03", 3, 2, 1699, "32'0\" x 56'0\"", "https://www.championhomes.com/models/ironclad-3256-03/configure?v=4&s=0:0,1:0,2:0,3:0,4:0"),
    ("Ironclad 32x60", 4, 2, 1820, "32'0\" x 60'0\"", "https://www.championhomes.com/models/ironclad-3260"),
    ("Ironclad 32x64 07", 4, 2, 1941, "32'0\" x 64'0\"", "https://www.championhomes.com/models/ironclad-3264-07"),
    ("Ironclad 32x68 12", 3, 2, 2063, "32'0\" x 68'0\"", "https://www.championhomes.com/models/ironclad-3268-12"),
    ("Ironclad 32x76 21", 4, 2.5, 2305, "32'0\" x 76'0\"", "https://www.championhomesofnc.com/home-plans-photos/ironclad-3276-21?location=Goldsboro,+NC,+27534&radius=75+miles&floorplans=primary-bath:standard"),
]
for i, row in enumerate(ironclad):
    LISTINGS.append(listing(row[0], "Ironclad", "Champion", row[1], row[2], row[3], row[4], row[5], featured=(i==14)))

# ── Champion Prime ──
prime_data = [
    ("1456H22P01", "Single Section", "14'0\" x 56'0\"", 784, 2, 2, "https://my.matterport.com/show/?play=1&m=KjNrfXCiaYR"),
    ("1460H22P01", "Single Section", "14'0\" x 60'0\"", 840, 2, 2, "https://my.matterport.com/show/?play=1&m=74hBvD3t2hP"),
    ("1466H32P01", "Single Section", "14'0\" x 66'0\"", 924, 3, 2, "https://my.matterport.com/show/?play=1&m=Sq84QJ56wp6"),
    ("1466H32P02", "Single Section", "14'0\" x 66'0\"", 924, 3, 2, None, "Just a different layout. Contact us for more information"),
    ("1476H32P01", "Single Section", "14'0\" x 76'0\"", 1064, 3, 2, "https://my.matterport.com/show/?play=1&m=V58bFAX9E9P"),
    ("1476H42P01", "Single Section", "14'0\" x 76'0\"", 1064, 4, 2, None, "No 3d tour found. Contact us for more information"),
    ("1636H11P01", "Single Section", "16'0\" x 36'0\"", 576, 1, 1, "https://my.matterport.com/show/?play=1&m=WUnHmaSZUMv"),
    ("1656H22P01", "Single Section", "16'0\" x 56'0\"", 896, 2, 2, "https://my.matterport.com/show/?play=1&m=jReDcyQfkyc"),
    ("1656H32P05", "Single Section", "16'0\" x 56'0\"", 896, 3, 2, "https://my.matterport.com/show/?play=1&m=bKuBDuPgt3c"),
    ("1660H22P01", "Single Section", "16'0\" x 60'0\"", 960, 2, 2, "https://my.matterport.com/show/?m=Ke27AHAsteg"),
    ("1660H22P16", "Single Section", "16'0\" x 60'0\"", 960, 2, 2, "https://my.matterport.com/show/?play=1&m=YbZLy5GYhaM"),
    ("1660H32P05", "Single Section", "16'0\" x 60'0\"", 960, 3, 2, None, "No 3d tour available. Contact us for more information"),
    ("1666H32P01", "Single Section", "16'0\" x 66'0\"", 1056, 3, 2, "https://my.matterport.com/show/?m=FUp3n5MePPY"),
    ("1666H32P02", "Single Section", "16'0\" x 66'0\"", 1056, 3, 2, None, "No 3d tour, same as above, just a different layout. Contact us for more information"),
    ("1672H32P01", "Single Section", "16'0\" x 72'0\"", 1152, 3, 2, "https://manufacturedcountryhomes.com/home/chpr-1672h32p01/", "Photos of the interior are supplied at this link"),
    ("1676H32P01", "Single Section", "16'0\" x 76'0\"", 1216, 3, 2, "https://my.matterport.com/show/?m=Bjrdkn7Ho1q"),
    ("1676H32P06", "Single Section", "16'0\" x 76'0\"", 1216, 3, 2, "https://my.matterport.com/show/?play=1&m=gXm21jnnyWD"),
    ("2844H32P01", "Double Section", "28'0\" x 44'0\"", 1232, 3, 2, None, "No 3d tour available. Contact us for more information"),
    ("2848H32P06", "Double Section", "28'0\" x 48'0\"", 1344, 3, 2, "https://my.matterport.com/show/?play=1&m=qyjVgYGUVT4"),
    ("2852H32P01", "Double Section", "28'0\" x 52'0\"", 1456, 3, 2, None, "No 3d tour available. Contact us for more information"),
    ("2852H32P02", "Double Section", "28'0\" x 52'0\"", 1456, 3, 2, None, "No 3d tour or champion link. Contact us for more information"),
    ("2856H32P01", "Double Section", "28'0\" x 56'0\"", 1568, 3, 2, "https://my.matterport.com/show/?m=YYGNMzKZEsa"),
    ("2856H42P01", "Double Section", "28'0\" x 56'0\"", 1568, 4, 2, "https://my.matterport.com/show/?m=DwgJSgkjXF2"),
    ("2876H53P01", "Double Section", "28'0\" x 76'0\"", 2128, 5, 3, "https://my.matterport.com/show/?m=PMNy86Pmi96"),
    ("3252H32P03", "Double Section", "32'0\" x 52'0\"", 1664, 3, 2, "https://my.matterport.com/show/?m=znRfHHppJG3"),
    ("3252H32P08", "Double Section", "32'0\" x 52'0\"", 1664, 3, 2, "https://my.matterport.com/show/?play=1&m=8iDfABDZmgi"),
    ("3256H32P03", "Double Section", "32'0\" x 56'0\"", 1792, 3, 2, "https://www.championhomes.com/models/prime-3256h32p03/configure?v=4&s=0:0"),
    ("3256H42P01", "Double Section", "32'0\" x 56'0\"", 1792, 4, 2, None, "No 3d tour or champion link contact us for more information"),
    ("3256H42P03", "Double Section", "32'0\" x 56'0\"", 1792, 4, 2, "https://www.championhomes.com/models/prime-3256h42p03"),
    ("3260H32P03", "Double Section", "32'0\" x 60'0\"", 1920, 3, 2, "https://my.matterport.com/show/?play=1&m=b3UXesRg58u"),
    ("3260H42P03", "Double Section", "32'0\" x 60'0\"", 1920, 4, 2, "https://my.matterport.com/show/?m=Kc5micAJQTn"),
    ("3268H42P03", "Double Section", "32'0\" x 68'0\"", 2176, 4, 2, None, "No 3d tour/No champion link. Contact us for more information"),
    ("3276H42P03", "Double Section", "32'0\" x 76'0\"", 2432, 4, 2, "https://my.matterport.com/show/?play=1&m=1XkaEkEvkvg"),
    ("3276H53P03", "Double Section", "32'0\" x 76'0\"", 2432, 5, 3, "https://www.championhomes.com/models/mammoth"),
    ("3276H63P03", "Double Section", "32'0\" x 76'0\"", 2432, 6, 3, None, "No 3d tour/No Champion link. Contact us for more information"),
]
for row in prime_data:
    tour = row[6] if row[6] and "matterport" in str(row[6]) else ""
    ext = row[6] if row[6] and "matterport" not in str(row[6]) else (row[6] or "")
    notes = row[7] if len(row) > 7 else ""
    sec = "single" if "Single" in row[1] else "double"
    LISTINGS.append(listing(row[0], "Prime", "Champion", row[4], row[5], row[3], row[2], ext, tour_url=tour, notes=notes, section=sec))

# ── Champion Lake Manor ──
lake_manor = [
    ("LKM-1456H22P01", 746, 2, 2, "14'0\" x 56'0\"", "https://fbhexpo.com/floorplan/manteo/"),
    ("LKM-1460H22P01", 800, 2, 2, "14'0\" x 60'0\"", "https://www.manufacturedhomes.com/home/237231-3462/champion-homes-center/lillington/lake-manor/1460h22p01/"),
    ("LKM-1466H32P01", 880, 3, 2, "14'0\" x 66'0\"", "https://fbhexpo.com/floorplan/boardman/"),
    ("LKM-1476H32P01", 1013, 3, 2, "14'0\" x 76'0\"", "https://fbhexpo.com/floorplan/rowland/"),
    ("LKM-1636H11P01", 546, 1, 1, "16'0\" x 36'0\"", "https://fbhexpo.com/floorplan/sheldon/"),
    ("LKM-1656H22P01", 849, 2, 2, "16'0\" x 56'0\"", "https://fbhexpo.com/floorplan/hertford/"),
    ("LKM-1660H22P01", 910, 2, 2, "16'0\" x 60'0\"", "https://fbhexpo.com/floorplan/aulander/"),
    ("LKM-1660H32P05", 910, 3, 2, "16'0\" x 60'0\"", "https://fbhexpo.com/floorplan/weldon/"),
    ("LKM-1666H32P01", 1001, 3, 2, "16'0\" x 66'0\"", "https://www.manufacturedhomes.com/home/237239-3462/champion-homes-center/lillington/lake-manor/1666h32p01/"),
    ("LKM-1672H32P01", 1092, 3, 2, "16'0\" x 72'0\"", "https://fbhexpo.com/floorplan/ellerbe/"),
    ("LKM-1676H32P01", 1153, 3, 2, "16'0\" x 76'0\"", "https://fbhexpo.com/floorplan/eure/"),
    ("LKM-2848H32P06", 1280, 3, 2, "28'0\" x 48'0\"", "https://fbhexpo.com/floorplan/reynoldson/"),
    ("LKM-2852H32P01", 1391, 3, 2, "28'0\" x 52'0\"", "https://fbhexpo.com/floorplan/powells/"),
    ("LKM-2852H32P02", 1391, 3, 2, "28'0\" x 52'0\"", "https://www.manufacturedhomes.com/home/237243-3462/champion-homes-center/lillington/lake-manor/2852h32p01/"),
    ("LKM-2856H32P01", 1493, 3, 2, "28'0\" x 56'0\"", "https://www.championhomes.com/models/lake-manor-2856h42383"),
    ("LKM-2856H32P02", 1493, 3, 2, "28'0\" x 56'0\"", "https://www.championhomes.com/models/lake-manor-2856h32p02-023"),
    ("LKM-2856H42P01", 1493, 4, 2, "28'0\" x 56'0\"", "https://fbhexpo.com/floorplan/paige/"),
    ("LKM-2868H42P01", 1813, 4, 2, "28'0\" x 68'0\"", "https://www.championhomes.com/models/lake-manor-2868h42p01"),
    ("LKM-2876H53P01", 2033, 5, 3, "28'0\" x 76'0\"", "https://selectmobilehomes.com/floorplan/conestee/"),
    ("LKM-3252H32P03", 1577, 3, 2, "32'0\" x 52'0\"", "https://www.manufacturedhomes.com/home/237250-5427/modulars-only/kinston/lake-manor/3252h32p03/"),
    ("LKM-3256H32P03", 1699, 3, 2, "32'0\" x 56'0\"", "https://www.manufacturedhomes.com/home/237251-3462/champion-homes-center/lillington/lake-manor/3256h32p03/"),
    ("LKM-3256H42P03", 1699, 4, 2, "32'0\" x 56'0\"", "https://www.manufacturedhomes.com/home/237252-3462/champion-homes-center/lillington/lake-manor/3256h42p03/"),
    ("LKM-3260H32P03", 1820, 3, 2, "32'0\" x 60'0\"", "https://www.championhomes.com/models/lake-manor-3260h32p03"),
    ("LKM-3276H42P03", 2033, 4, 2, "32'0\" x 76'0\"", "https://selectmobilehomes.com/floorplan/wampee/"),
]
for row in lake_manor:
    LISTINGS.append(listing(row[0], "Lake Manor", "Champion", row[2], row[3], row[1], row[4], row[5]))

# ── Champion Altitude ──
altitude = [
    ("Bremond ATM-3256H32P01", 1699, 3, 2, "32'0\" x 56'0\"", "https://fbhexpo.com/floorplan/bremond/"),
    ("Kritzer ATM-3256H32P02", 1699, 3, 2, "32'0\" x 56'0\"", "https://www.championhomes.com/blog/featured-home-series-soar-to-your-dream-home-with-the-new-altitude-series-of-homes"),
    ("Engelwood ATM-3260H42P01", 1884, 4, 2, "32'0\" x 60'0\"", "https://fbhexpo.com/floorplan/engelwood/"),
    ("Everest ATM-3264H42P01", 2005, 4, 2, "32'0\" x 64'0\"", None, "Contact us for more information"),
]
for row in altitude:
    LISTINGS.append(listing(row[0], "Altitude", "Champion", row[2], row[3], row[1], row[4], row[5], notes=(row[6] if len(row) > 6 else "")))

# Add descriptions
for item in LISTINGS:
    item["description"] = (
        f"{item['series']} / {item['name']} — Premium {item['section']} section manufactured home "
        f"by {item['manufacturer']}. {item['beds']} bedrooms, {item['baths']} baths, "
        f"{item['sqft']:,} sq. ft. at {item['dimensions']}. Offered by Outlandis Corp, South Carolina."
    )

featured = [l for l in LISTINGS if l.get("featured")]
if len(featured) < 6:
    featured = LISTINGS[:6]

output = f"""/**
 * Outlandis Homes — Complete property catalog from PDF
 * Auto-generated: {len(LISTINGS)} floor plans
 */
const OUTLANDIS_LISTINGS = {{
  catalog: {json.dumps(LISTINGS, indent=2)},
  featured: {json.dumps(featured[:6], indent=2)}
}};

function getListingById(id) {{
  return OUTLANDIS_LISTINGS.catalog.find(l => l.id === id || l.slug === id);
}}

function getListingBySlug(slug) {{
  return OUTLANDIS_LISTINGS.catalog.find(l => l.slug === slug);
}}
"""

with open("/workspace/outlandis-homes-redesign/js/listings-data.js", "w") as f:
    f.write(output)

print(f"Generated {len(LISTINGS)} listings")
