export const labyrinthHours = [
  { date: 'Friday, September 18', hours: '6–10pm' },
  { date: 'Saturday, September 19', hours: '6–10pm' },
  { date: 'Sunday, September 20', hours: '6–10pm' },
  { date: 'Friday, September 26', hours: '6–10pm' },
  { date: 'Saturday, September 27', hours: '6–10pm' },
  { date: 'Sunday, September 28', hours: '6–10pm' },
  { date: 'Friday, October 2', hours: '6–11pm' },
  { date: 'Saturday, October 3', hours: '6–11pm' },
  { date: 'Sunday, October 4', hours: '6–10pm' },
  { date: 'Friday, October 9', hours: '6–11pm' },
  { date: 'Saturday, October 10', hours: '6–11pm' },
  { date: 'Sunday, October 11', hours: '6–10pm' },
  { date: 'Friday, October 16', hours: '6–11pm' },
  { date: 'Saturday, October 17', hours: '6–11pm' },
  { date: 'Sunday, October 18', hours: '6–10pm' },
  { date: 'Friday, October 23', hours: '6–12am' },
  { date: 'Saturday, October 24', hours: '6–12am' },
  { date: 'Sunday, October 25', hours: '6–10pm' },
  { date: 'Wednesday, October 28', hours: '6–11pm' },
  { date: 'Thursday, October 29', hours: '6–11pm' },
  { date: 'Friday, October 30', hours: '6–12am' },
  { date: 'HALLOWEEN', hours: '5–12am' },
  { date: 'Sunday, November 1', hours: '6–10pm' },
];

export const labyrinthTickets = {
  notes: [
    'Due to the intense nature of Payne\'s Labyrinth, patrons must be 12 or older to enter.',
    'Patrons under the age of 12 must be accompanied by a guardian over the age of 18.',
    'Patrons 15–17 may enter unaccompanied with a waiver signed by a guardian.',
    'It is HIGHLY recommended that patrons under the age of 18 call ahead for approval for a drop-off.',
    'All tickets are good for any open day of the current season.',
    'For groups of 15 or more, please inquire for discounted rates.',
  ],
  tickets: [
    {
      id: 'regular',
      name: 'Regular Admission',
      price: '$50.00',
      per: 'per person',
      description:
        'Valid for any single open day this season at Payne\'s Labyrinth. This ticket is not timed, and you\'re welcome to enjoy the attractions for the full duration of operating hours.',
    },
    {
      id: 'single-4-pack',
      name: 'Single Day 4 Pack',
      price: '$170.00',
      description:
        'Valid for any single open day this season at Payne\'s Labyrinth. Tickets are not timed, and you\'re welcome to enjoy the attractions for the full duration of operating hours.',
    },
    {
      id: 'season-pass',
      name: 'Season Pass',
      price: '$125.00',
      per: 'per person',
      description:
        'Use this pass on any open day this season at Payne\'s Labyrinth, as many times as you like. No timed entry—stay and explore for the full operating hours.',
    },
    {
      id: 'season-4-pack',
      name: 'Season Pass 4 Pack',
      price: '$300.00',
      description:
        'Use this pass on any open day this season at Payne\'s Labyrinth, as many times as you like. No timed entry—stay and explore for the full operating hours.',
    },
    {
      id: 'fast-pass',
      name: 'Fast Pass',
      price: '$15',
      description:
        'Skip the line at all our attractions! Fast passes may only be used once at The Barn due to the timed nature of the attraction. Fast passes are for single day use ONLY and may ONLY be used at Payne\'s Labyrinth.',
    },
    {
      id: 'parking',
      name: 'Parking',
      price: '$10',
      badge: 'CASH ONLY',
      description: 'Parking is cash only. There is NO ATM onsite.',
    },
  ],
  comboTickets: [
    {
      id: 'combo-pass',
      name: 'Combo Pass',
      price: '$65.00',
      per: 'per person',
      description:
        'Good for one visit this season to Ichabod Payne\'s Sleepy Hollow and one visit to Payne\'s Labyrinth. Visits may be used on different days. Please note that adults must be accompanied by a child to enter Sleepy Hollow.',
    },
    {
      id: 'ultimate-season',
      name: 'Ultimate Season Pass',
      price: '$175.00',
      per: 'per person',
      description:
        'Good for unlimited visits this season to Payne\'s Labyrinth and Ichabod Payne\'s Sleepy Hollow. Also enjoy $5 parking, CASH ONLY. Please show your lanyard badge to the parking attendant.',
    },
  ],
};

export const labyrinthAttractions = [
  {
    name: 'The Labyrinth',
    tagline: 'Step into The Labyrinth—where the walls have a mind of their own.',
    description:
      'Think you can find your way out? Think again. The Labyrinth isn\'t just a maze; it\'s a living, breathing nightmare that shifts, mutates, and rewrites itself while you\'re trapped inside. The path you took to get in? Gone. The exit you thought you saw? A dead end. Every corner hides a new terror, and every dead end brings you closer to what\'s hunting you. In this ever-changing hellscape, your sense of direction won\'t save you. Only your survival instinct will. This attraction mutates overnight, so your experience will not be the same from one day to the next!',
    icon: 'route',
  },
  {
    name: 'The Barn',
    tagline: 'The engine is idling. The door is locked. Your time is running out.',
    description:
      'Off the beaten path sits The Barn—a dilapidated, rusted structure that reeks of copper and old rot. You thought you were just taking a detour, but now you\'re locked inside the butcher shop of a twisted, cannibalistic family. The floorboards are stained, the meat hooks are waiting, and the sickening rev of a chainsaw is echoing from just behind the walls. You have 30 minutes to piece together the family\'s sick puzzles and find a way out before the butcher comes back to finish his work.',
    icon: 'warehouse',
  },
  {
    name: 'Magician\'s Escape Room',
    tagline: 'Can you escape before time runs out?',
    description:
      'Test your wits against the Magician\'s twisted puzzles in this immersive escape room experience.',
    icon: 'wand-2',
  },
  {
    name: 'Hayride',
    tagline: 'Your descent begins the moment you leave your car.',
    description:
      'Your descent into the festival begins the moment you leave your car. This isn\'t just a ride from the parking lot—it\'s a one-way trip across an isolated, dark pasture where the boundary between our world and the supernatural wears dangerously thin.',
    icon: 'tractor',
  },
  {
    name: 'Fun House',
    tagline: 'Reality just lost a dimension.',
    description:
      'Grab your glasses and step into our funhouse, a dizzying walk-through that weaponizes color and depth. Lose yourself in a psychedelic maze of neon walls and mind-bending optical illusions.',
    icon: 'eye',
  },
  {
    name: 'Cotton Candy Cauldron',
    tagline: 'Spun from the silk of your deepest nightmares…',
    description:
      'Follow the sweet, hypnotic scent of burning sugar to our most twisted concession station, where the treats are sweet but the atmosphere is downright chilling. Looking suspiciously like thick, tangled cobwebs pulled straight from a crypt, this classic treat has been given a dark, eerie makeover. It\'s a sweet, fluffy reward for surviving the horrors of the night—or perhaps it\'s just bait to lure you closer.',
    price: '$3 per serving',
    icon: 'sparkles',
  },
  {
    name: 'Raiders of the Lost Snacks',
    tagline: 'SNAKES? NO. SNACKS? YES.',
    description:
      'Need a break from the terror? Raiders of the Lost Snacks is your go-to trading post for quick bites, sweet treasures, and refreshing drinks. Water and popcorn are always free–just ask!',
    icon: 'utensils',
  },
];

export const labyrinthWarningPoster = {
  headline: 'WARNING',
  subhead: 'READ THIS WARNING BEFORE ENTERING ANY OF THE ATTRACTIONS!',
  footer: 'THERE ARE NO REFUNDS. ENTER AT YOUR OWN RISK!',
  paragraphs: [
    'THIS ATTRACTION RESERVES THE RIGHT TO REFUSE ADMISSION TO ANYONE.',
    'YOU MAY EXPERIENCE INTENSE AUDIO, LIGHTING, EXTREME LOW VISIBILITY, STROBE LIGHTS, FOG, DAMP OR WET CONDITIONS, SPECIAL EFFECTS, SUDDEN ACTIONS, AND AN OVERALL PHYSICALLY DEMANDING ENVIRONMENT.',
    'YOU SHOULD NOT ENTER A HAUNTED HOUSE IF YOU SUFFER FROM ASTHMA, HEART CONDITIONS, ARE PRONE TO SEIZURES, PHYSICAL AILMENTS, RESPIRATORY AILMENTS, OR ANY TYPE OF MEDICAL PROBLEM, OR ARE PREGNANT OR SUFFER FROM ANY FORM OF MENTAL DISEASE, INCLUDING CLAUSTROPHOBIA.',
    'DO NOT ENTER THE ATTRACTION IF YOU ARE INTOXICATED, WEARING ANY FORM OF CAST, MEDICAL BRACE, ARE USING CRUTCHES, OR HAVE ANY TYPE OF PHYSICAL LIMITATION. DO NOT ENTER THE ATTRACTION IF YOU ARE TAKING MEDICATION OR USING DRUGS OF ANY TYPE.',
    'YOU WILL NOT BE ADMITTED IF THESE CONDITIONS ARE NOTICED BY STAFF.',
    'DO NOT SMOKE, RUN, EAT, OR DRINK INSIDE THE ATTRACTIONS.',
    'DO NOT TOUCH THE ACTORS, CUSTOMERS, OR PROPS INSIDE THE ATTRACTIONS.',
    'NO VIDEO OR FLASH PHOTOGRAPHY MAY BE TAKEN INSIDE THE ATTRACTIONS.',
    'YOU WILL NOT BE ADMITTED, OR YOU MAY BE ASKED TO LEAVE THE PROPERTY, IF ANY OF THE RULES ARE NOT FOLLOWED, OR FOR ANY REASON WHATSOEVER.',
  ],
};

export const labyrinthWarnings = [
  {
    title: 'Age Restrictions',
    content:
      'You must be 12 years of age to enter Payne\'s Labyrinth. Anyone under 15 must be accompanied by a guardian. Patrons 15–17 may enter unaccompanied with a signed waiver.',
    severity: 'high',
  },
  {
    title: 'Health Advisories',
    content:
      'Payne\'s Labyrinth is not recommended for visitors who are pregnant, have heart conditions, or are in general poor health.',
    severity: 'high',
  },
  {
    title: 'Fog, Haze & Scent Effects',
    content:
      'We use fog, haze, and scent machines throughout the attractions. Should you find the smoke or odors too intense, emergency exits are available throughout.',
    severity: 'medium',
  },
  {
    title: 'Strobe Lights',
    content: 'Strobe lights are used in multiple attractions. Proceed with caution if you are sensitive to flashing lights.',
    severity: 'medium',
  },
  {
    title: 'Physical Contact Nights',
    content:
      'On Saturday October 24th & Saturday October 31st after 9pm, actors are allowed to make physical contact ONLY if you have signed a waiver and are wearing the designated consent wristband.',
    severity: 'high',
  },
  {
    title: 'No Photography or Video',
    content:
      'Any photography and video recording (including GoPros) are not permitted in Payne\'s Labyrinth and may result in removal without a refund.',
    severity: 'medium',
  },
  {
    title: 'Strict No-Bag Policy',
    content:
      'For everyone\'s safety, all bags and purses must be left at home. Loose items must be secured in pockets.',
    severity: 'medium',
  },
  {
    title: 'Actor Contact Policy',
    content:
      'Actors will not intentionally touch guests, but accidental contact may occur in dark, tight spaces. NEVER touch actors — intentional contact will result in immediate removal and possible assault charges.',
    severity: 'high',
  },
  {
    title: 'Intoxication Policy',
    content:
      'We do not serve alcohol. Visitors who appear intoxicated will not be permitted to enter the attractions.',
    severity: 'high',
  },
];

export const labyrinthFaq = [
  { question: 'Can I buy tickets in advance?', answer: 'Yes and it is preferred! You can purchase tickets online and groups of 15 or more will receive a 15% discount.' },
  { question: 'Do you accept credit cards?', answer: 'Yes. We only accept (and you must pay) cash at parking.' },
  { question: 'What attractions are included in the admission price?', answer: 'It\'s easier to say what is not included: lazer tag and concessions. Free water & popcorn is provided.' },
  { question: 'Is there a way to avoid waiting in line?', answer: 'Yes, the FastPass upgrade for $15 lets you skip the line on all attractions except The Barn.' },
  { question: 'Are there any age restrictions?', answer: 'You must be 12 years of age to enter Payne\'s Labyrinth and anyone under 15 must be accompanied by a guardian. No refunds if anyone decides not to finish the haunt.' },
  { question: 'Is there a lot of smoke in the haunted house?', answer: 'We do use fog, haze, and scent machines. Should you find the smoke or odors too intense there are emergency exits throughout.' },
  { question: 'Are there strobe lights?', answer: 'Yes.' },
  { question: 'Can I go in if I\'m pregnant?', answer: 'Payne\'s Labyrinth is not recommended for visitors who are pregnant, have heart conditions or are in general poor health.' },
  { question: 'Can I bring my bag into the haunt?', answer: 'We have a strict no-bag policy for everyone\'s safety. Please leave all bags or purses at home.' },
  { question: 'What can\'t we bring with us inside?', answer: 'No weapons, pets, alcoholic beverages, cameras, flashlights, laser pointers, food or beverage, cigarettes, lighters, incendiary devices, fireworks, drones, or illicit or illegal substances.' },
  { question: 'Is smoking allowed?', answer: 'No, smoking of cigarettes or illegal substances is not allowed at Payne\'s Labyrinth.' },
  { question: 'Can I wear a costume?', answer: 'Yes, keeping in mind the following rules. No masks. No props. No prosthetics. No special effects makeup that conceals your identity. Closed toed shoes recommended. Costumes must be reasonably modest.' },
  { question: 'Will the actors touch me?', answer: 'Actors will not intentionally touch or grab our guests. However, because of the dark and sometimes tight nature of the haunted house, an actor may graze or run into you. The exception is Saturday October 24th & Saturday October 31st after 9pm for waiver participants.' },
  { question: 'Is there security?', answer: 'Private security will be on-site every night. We require each person to pass through security screening before entering the waiting line.' },
  { question: 'Do you serve alcoholic beverages?', answer: 'No, we do not serve or sell alcohol.' },
  { question: 'Do you charge for parking?', answer: 'Yes. Parking is $10 CASH ONLY. There is NO ATM onsite.' },
  { question: 'Can we touch the actors?', answer: 'Absolutely not. Intentionally touching an actor can result in immediate removal without a refund along with assault charges filed!' },
  { question: 'Can I leave & come back?', answer: 'Yes, you have in & out privileges. Please keep your wristband on to guarantee re-entry.' },
  { question: 'Can we take photos & videos inside?', answer: 'Any photography and video recording are not permitted in Payne\'s Labyrinth. Media outlets may apply for a press pass by emailing eerie.ever.after.events@gmail.com at least 1 business day in advance.' },
];

export const specialEvents = [
  { name: 'Friday the 13th', date: 'Friday, November 13', status: 'More info coming soon!' },
  { name: 'Black Friday', date: 'November 27', status: 'More info coming soon!' },
  { name: 'New Year\'s Eve', date: 'December 31', status: 'More info coming soon!' },
  { name: 'Bloody Valentine', date: 'February 14', status: 'More info coming soon!' },
];
