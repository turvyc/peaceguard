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

//it is the function to start patrol
- (IBAction)GenerateLocation:(id)sender {
    self.connectionManager = [[ConnectionDataController alloc] init];
    self.patrolID = [self.connectionManager startPatrolWithEmail:self.username];
    
    locationManager.delegate = self;
    locationManager.desiredAccuracy = kCLLocationAccuracyBest;
    [_timer startTimer];
    _start = YES;
    [locationManager startUpdatingLocation];
    //[locationManager stopUpdatingLocation];
    NSDate *currDate = [NSDate date];
    NSDateFormatter *dateFormatter = [[NSDateFormatter alloc]init];
    [dateFormatter setDateFormat:@"dd.MM.YY HH:mm:ss"];
    NSString *dateString = [dateFormatter stringFromDate:currDate];
    self.start_time = dateString;
    NSLog(@"start Patrol");
    NSLog(@"The patrol ID is %i",self.patrolID);
//    _thread = [[NSThread alloc] initWithTarget:self
//                                               selector:@selector(route)
//                                                 object:nil];
//    [_thread start];
}

//- (void)route
//{
//    while(YES){
//        [NSThread sleepForTimeInterval:1];
//        [locationManager startUpdatingLocation];
//        //NSLog(@"test location manager");
//    }
//}

- (void)locationManager:(CLLocationManager *)manager didUpdateToLocation:(CLLocation *)newLocation fromLocation:(CLLocation *)oldLocation
{
//    NSLog(@"didUpdateToLocation: %@", newLocation);
    CLLocation *currentLocation = newLocation;
    if(_start == YES){
        if(_start_location == nil){
            _start_location = newLocation;
        }
    }else{
        _final_location = newLocation;
    }

    if (currentLocation != nil) {
        NSString *longitude = [NSString stringWithFormat:@"%.8f", currentLocation.coordinate.longitude];
        NSString *latitude= [NSString stringWithFormat:@"%.8f", currentLocation.coordinate.latitude];
        //[NSThread sleepForTimeInterval:1];
        NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
        [defaults setObject:latitude forKey:@"starLatitude"];
        [defaults setObject:longitude forKey:@"starLongitude"];
        [defaults synchronize];
        CLLocation *temp_location = [[CLLocation alloc] init];
        if([_myArray lastObject] != nil){
             temp_location = [_myArray lastObject];
        }
        if(temp_location != nil){
            CLLocationDistance meters = [temp_location distanceFromLocation:newLocation];
//            NSLog(@"%4.0f km from current location",meters);
            _sum += meters;
        }
//        NSLog(@"%4.0f total distance",_sum/10000000);
    }
    
    // Reverse Geocoding
//    NSLog(@"Resolving the Address");
    [geocoder reverseGeocodeLocation:currentLocation completionHandler:^(NSArray *placemarks, NSError *error) {
//        NSLog(@"Found placemarks: %@, error: %@", placemarks, error);
        if (error == nil && [placemarks count] > 0) {
            placemark = [placemarks lastObject];
            _Address.text = [NSString stringWithFormat:@"%@ %@\n%@ %@\n%@\n%@",
                                 placemark.subThoroughfare, placemark.thoroughfare,
                                 placemark.postalCode, placemark.locality,
                                 placemark.administrativeArea,
                                 placemark.country];
            self.current_location = _Address.text;
            [_myArray addObject:newLocation];
        } else {
            NSLog(@"%@", error.debugDescription);
        }
    } ];
    if(_start == YES){
       // NSLog(@"Location is %@",_Address.text);
        //        MKCoordinateRegion viewRegion = MKCoordinateRegionMakeWithDistance(currentLocation.coordinate, 0.5*METERS_PER_MILE, 0.5*METERS_PER_MILE);
//        MKCoordinateRegion adjustRegion = [_mapView regionThatFits:viewRegion];
//        [_mapView setRegion:adjustRegion animated:YES];
//        MKPointAnnotation *point = [[MKPointAnnotation alloc] init];
//        point.coordinate = currentLocation.coordinate;
//        point.title = @"where am i";
//        point.subtitle = @"I'm here";
//        [_mapView addAnnotation:point];
    }else{
        NSLog(@"finalLocation is %@",_Address.text);
    }
}


- (IBAction)StopPatrol:(id)sender {
//        [_thread cancel];
//        [_thread release];
//        locationManager.delegate = self;
//        locationManager.desiredAccuracy = kCLLocationAccuracyBest;
        NSLog(@"The patrol ID is %i",self.patrolID);
        _start = NO;
        [NSThread sleepForTimeInterval:1];
//        [locationManager startUpdatingLocation];
        [locationManager stopUpdatingLocation];
        [_timer stopTimer];
        NSString *timerString = [NSString stringWithFormat:@"%f",[_timer timeElapsedInSeconds]];
        _timeDisplay.text = timerString;
        NSLog(@"stop Patrol");
        //distance count here
        CLLocationDistance meters = [_final_location distanceFromLocation:_start_location];
        NSString *distanceString = [NSString stringWithFormat:@"%f",meters/1000];
        _distanceDisplay.text = distanceString;
        self.connectionManager = [[ConnectionDataController alloc] init];
        [self.connectionManager endAndSendPatrolID:self.patrolID duration:(NSInteger)[self.timer timeElapsedInSeconds] route:@"TEST_ROUTE" distance:meters/1000];
}

- (IBAction)reportButton:(id)sender {
    self.segueType = @"report";
    [self performSegueWithIdentifier:@"locationToReport" sender:self];
}

-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender{
    
    if([self.segueType isEqualToString:@"report"]){
    ReportViewController *report = (ReportViewController *)segue.destinationViewController;
    if(self.current_location != nil){
        report.location = self.current_location;
    }
    report.username = self.username;
    report.isPatrolling = @"YES";
    }
}

@end
