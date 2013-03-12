//
//  LocationViewController.m
//  peaceguard
//
//  Created by JonasYao on 2013-03-10.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "LocationViewController.h"

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
    [super viewDidLoad];
    locationManager = [[CLLocationManager alloc] init];
    geocoder = [[CLGeocoder alloc] init];
    _myArray = [[NSMutableArray alloc] init];

	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (IBAction)GenerateLocation:(id)sender {
    locationManager.delegate = self;
    locationManager.desiredAccuracy = kCLLocationAccuracyBest;
    _thread = [[NSThread alloc] initWithTarget:self
                                               selector:@selector(route)
                                                 object:nil];
    [_thread start];
}

- (void)route
{
    while(YES){
        [NSThread sleepForTimeInterval:1];
        [locationManager startUpdatingLocation];
        //NSLog(@"test location manager");
    }
}
- (void)locationManager:(CLLocationManager *)manager didUpdateToLocation:(CLLocation *)newLocation fromLocation:(CLLocation *)oldLocation
{
//    NSLog(@"didUpdateToLocation: %@", newLocation);
    CLLocation *currentLocation = newLocation;

    if (currentLocation != nil) {
//        _longitudeLabel.text = [NSString stringWithFormat:@"%.8f", currentLocation.coordinate.longitude];
//        _latitudeLabel.text = [NSString stringWithFormat:@"%.8f", currentLocation.coordinate.latitude];
        //[NSThread sleepForTimeInterval:1];
        CLLocation *temp_location = [[CLLocation alloc] init];
        if([_myArray lastObject] != nil){
             temp_location = [_myArray lastObject];
        }
        if(temp_location != nil){
            CLLocationDistance meters = [temp_location distanceFromLocation:newLocation];
            NSLog(@"%4.0f km from current location",meters);
            _sum += meters;
        }
        NSLog(@"%4.0f total distance",_sum/10000000);
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
            [_myArray addObject:newLocation];
        } else {
            NSLog(@"%@", error.debugDescription);
        }
    } ];
}


    - (IBAction)StopPatrol:(id)sender {
//        [_thread cancel];
//        [_thread release];
        NSLog(@"stop thread");
    }
@end
