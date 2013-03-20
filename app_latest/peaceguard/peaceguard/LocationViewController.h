//
//  LocationViewController.h
//  peaceguard
//
//  Created by JonasYao on 2013-03-10.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//
#import <CoreLocation/CoreLocation.h>
#import <UIKit/UIKit.h>
#import "Timer.h"
#import "ConnectionDataController.h"
#import <MapKit/MapKit.h>



@interface LocationViewController : UIViewController <CLLocationManagerDelegate>
- (IBAction)GenerateLocation:(id)sender;
@property (weak, nonatomic) IBOutlet UITextField *Address;
@property (nonatomic) CLLocationDistance sum;
@property (nonatomic) NSMutableArray *myArray;
@property (nonatomic) NSThread *thread;
- (IBAction)StopPatrol:(id)sender;
//Duration of time for a patrol
@property (weak, nonatomic) IBOutlet UITextField *timeDisplay;
@property (nonatomic) Timer *timer;
//Distance of patrol
@property (nonatomic) CLLocation *start_location;
@property (nonatomic) CLLocation *final_location;
@property (nonatomic) NSString *current_location;
@property (weak, nonatomic) IBOutlet UITextField *distanceDisplay;
@property (nonatomic) BOOL *start;
@property (nonatomic) int report_id;
@property (nonatomic) NSString* username;
@property (nonatomic) NSString* start_time;
@property (nonatomic, strong) ConnectionDataController *connectionManager;
@property (nonatomic) NSInteger patrolID;

- (IBAction)reportButton:(id)sender;
@property(nonatomic) NSString *segueType;






@end
