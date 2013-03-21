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
    NSLog(@"username-location:%@", self.username);
    [super viewDidLoad];
    locationManager = [[CLLocationManager alloc] init];
    geocoder = [[CLGeocoder alloc] init];
    _myArray = [[NSMutableArray alloc] init];
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
    self.connectionManager = [[ConnectionDataController alloc] init];
    self.patrolID = [self.connectionManager startPatrolWithEmail:self.username];
    
    locationManager.delegate = self;
    locationManager.desiredAccuracy = kCLLocationAccuracyBest;
    [_timer startTimer];
    _start = YES;
    _cache_number = 3;
    [locationManager startUpdatingLocation];
    NSDate *currDate = [NSDate date];
    NSDateFormatter *dateFormatter = [[NSDateFormatter alloc]init];
    [dateFormatter setDateFormat:@"dd.MM.YY HH:mm:ss"];
    NSString *dateString = [dateFormatter stringFromDate:currDate];
    self.start_time = dateString;
    NSLog(@"start Patrol");
    NSLog(@"The patrol ID is %i",self.patrolID);
}

//Opening a GPS to start a patrol and gather the location,time and distance for the patrol 
- (void)locationManager:(CLLocationManager *)manager didUpdateToLocation:(CLLocation *)newLocation fromLocation:(CLLocation *)oldLocation
{
    CLLocation *currentLocation = newLocation;
    if (currentLocation != nil)
    {
        NSString *longitude = [NSString stringWithFormat:@"%.8f", currentLocation.coordinate.longitude];
        NSString *latitude= [NSString stringWithFormat:@"%.8f", currentLocation.coordinate.latitude];
        NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
        [defaults setObject:latitude forKey:@"starLatitude"];
        [defaults setObject:longitude forKey:@"starLongitude"];
        [defaults synchronize];
    }
    
    // Reverse Geocoding converts latitude and longitude to a readable location 
    [geocoder reverseGeocodeLocation:currentLocation completionHandler:^(NSArray *placemarks, NSError *error) {
            if (error == nil && [placemarks count] > 0)
            {
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
                [_myArray addObject:newLocation];
            } else
            {
                NSLog(@"%@", error.debugDescription);
            }
        }
    ];
    _cache_number--;
    if (_start == YES && _cache_number == 0 )
    {
        if (_start_location == nil)
        {
            _start_location = newLocation;
            NSLog(@"startLocation is %@",_Address.text);
            _start = NO;
        }
    }
    [_myArray addObject:newLocation];


}


- (IBAction)StopPatrol:(id)sender {
        NSLog(@"The patrol ID is %i",self.patrolID);
        CLLocationDistance meters = 0;

        //Stop all the location and timer tool, also record the data
        [locationManager stopUpdatingLocation];
        [_timer stopTimer];
        NSString *timerString = [NSString stringWithFormat:@"%f",[_timer timeElapsedInSeconds]];
        _timeDisplay.text = timerString;
    
        NSLog(@"stop Patrol");
    
        //Use CLLocationDistance to count the distance of patrolling
        _final_location = [_myArray lastObject];
        if (_start_location != nil && _final_location != nil)
        {
            meters = [_final_location distanceFromLocation:_start_location];
            NSString *distanceString = [NSString stringWithFormat:@"%f",meters/1000];
            NSLog(@"The distance is %@",distanceString);
            if(meters/1000 != 0)
            {
                _distanceDisplay.text = distanceString;
            }else
            {
                _distanceDisplay.text = [NSString stringWithFormat:@"%f",0.000000];
            }
        }
    
        //After stop patrolling, application sends the duration, distance and patrol ID to the server
        self.connectionManager = [[ConnectionDataController alloc] init];
        [self.connectionManager endAndSendPatrolID:self.patrolID duration:(NSInteger)[self.timer timeElapsedInSeconds] route:@"TEST_ROUTE" distance:meters/1000];
}

- (IBAction)reportButton:(id)sender {
    self.segueType = @"report";
    [self performSegueWithIdentifier:@"locationToReport" sender:self];
}

-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender{
    if([self.segueType isEqualToString:@"report"])
    {
        ReportViewController *report = (ReportViewController *)segue.destinationViewController;
        report.username = self.username;
        report.isPatrolling = @"YES";
    }
}

@end
