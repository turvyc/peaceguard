//
//  LocationViewController.m
//  peaceguard
//
//  Created by JonasYao on 2013-03-10.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "LocationViewController.h"
#import "ReportViewController.h"

@interface LocationViewController ()

@end

@implementation LocationViewController{
    CLLocationManager *locationManager;
    CLGeocoder *geocoder;
    CLPlacemark *placemark;
}

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }

    return self;
}

- (void)viewDidLoad
{
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    NSString *username = [defaults objectForKey:@"username"];
    self.username = username;
    NSLog(@"username in the location view :%@", self.username);
    [super viewDidLoad];
    locationManager = [[CLLocationManager alloc] init];
    geocoder = [[CLGeocoder alloc] init];
    _location_array = [[NSMutableArray alloc] init];
    _timer = [[Timer alloc] init];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

//Press the start patrol button and start the patrol action
- (IBAction)GenerateLocation:(id)sender
{
    NSLog(@"start Patrol");
    NSLog(@"The patrol ID is %i",self.patrolID);
    //all initialize
    self.connectionManager = [[ConnectionDataController alloc] init];
    self.patrolID = [self.connectionManager startPatrolWithEmail:self.username];
    locationManager.delegate = self;
    locationManager.desiredAccuracy = kCLLocationAccuracyBest;
    [_timer startTimer];
    _start = YES;
    _cache_number = 1;
    [locationManager startUpdatingLocation];
    NSDate *currDate = [NSDate date];
    NSDateFormatter *dateFormatter = [[NSDateFormatter alloc]init];
    [dateFormatter setDateFormat:@"dd.MM.YY HH:mm:ss"];
    NSString *dateString = [dateFormatter stringFromDate:currDate];
    self.start_time = dateString;
}

//Opening a GPS to start a patrol and gather the location,time and distance for the patrol 
- (void)locationManager:(CLLocationManager *)manager didUpdateToLocation:(CLLocation *)newLocation fromLocation:(CLLocation *)oldLocation
{
    CLLocation *currentLocation = newLocation;
    if (currentLocation != nil){
        NSString *longitude = [NSString stringWithFormat:@"%.8f", currentLocation.coordinate.longitude];
        NSString *latitude= [NSString stringWithFormat:@"%.8f", currentLocation.coordinate.latitude];
        NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
        [defaults setObject:latitude forKey:@"starLatitude"];
        [defaults setObject:longitude forKey:@"starLongitude"];
        [defaults synchronize];
    }
    
    // Reverse Geocoding converts latitude and longitude to a readable location 
    [geocoder reverseGeocodeLocation:currentLocation completionHandler:^(NSArray *placemarks, NSError *error) {
            if (error == nil && [placemarks count] > 0){
                placemark = [placemarks lastObject];
                _Address.text = [NSString stringWithFormat:@"%@ %@\n%@ %@\n%@\n%@",
                                 placemark.subThoroughfare, placemark.thoroughfare,
                                 placemark.postalCode, placemark.locality,
                                 placemark.administrativeArea,
                                 placemark.country];
                self.current_location = _Address.text;
                NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
                NSString *current_location = _Address.text;
                [defaults setObject:current_location forKey:@"currentLocation"];
                [defaults synchronize];
                [_location_array addObject:newLocation];
            } else{
                NSLog(@"%@", error.debugDescription);
            }
        }
    ];
    //To remember the start location, create a cache number to allow GPS start
    _cache_number--;
    //To remember the final location, it will create too much address but it's the only way
    [_location_array addObject:newLocation];
    if (_start == YES && _cache_number == 0 ){
        if (_start_location == nil){
            _start_location = newLocation;
            _start = NO;
            NSLog(@"startLocation is %@",_Address.text);
        }
    }
}

- (IBAction)StopPatrol:(id)sender
{
        NSLog(@"stop Patrol");
        NSLog(@"The patrol ID is %i",self.patrolID);
        CLLocationDistance meters = 0;

        //Stop all the location and timer tool, also record the data
        [locationManager stopUpdatingLocation];
        [_timer stopTimer];
        NSString *timerString = [NSString stringWithFormat:@"%f",[_timer timeElapsedInSeconds]];
        _timeDisplay.text = timerString;
    
        //Use CLLocationDistance to count the distance of patrolling
        _final_location = [_location_array lastObject];
        if(_final_location == nil){
            _final_location = _start_location;
        }
        if (_start_location != nil){
            meters = [_final_location distanceFromLocation:_start_location];
            NSString *distanceString = [NSString stringWithFormat:@"%f",meters/1000];
            NSLog(@"The distance is %@",distanceString);
            if(meters/1000 != 0.000000){
                _distanceDisplay.text = distanceString;
            }else{
                _distanceDisplay.text = [NSString stringWithFormat:@"%f",0.000000];
            }
        }
    
        //After stop patrolling, application sends the duration, distance and patrol ID to the server
        self.connectionManager = [[ConnectionDataController alloc] init];
        [self.connectionManager endAndSendPatrolID:self.patrolID duration:(NSInteger)[self.timer timeElapsedInSeconds] route:@"TEST_ROUTE" distance:meters/1000];
}

- (IBAction)reportButton:(id)sender
{
    self.segueType = @"report";
    [self performSegueWithIdentifier:@"locationToReport" sender:self];
}

//make global variable for is patrolling

-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
}

@end
