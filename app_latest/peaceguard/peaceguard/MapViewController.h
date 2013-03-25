//
//  MapViewController.h
//  peaceguard
//
//  Created by JonasYao on 2013-03-19.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <MapKit/MapKit.h>
#import "CrumbPath.h"
#import "CrumbPathView.h"
#import "ConnectionDataController.h"
#import "Timer.h"

#define METERS_PER_MILE 1609.344

@interface MapViewController : UIViewController <MKMapViewDelegate, CLLocationManagerDelegate, UIActionSheetDelegate>

@property (nonatomic) BOOL patrolling;
@property (strong, nonatomic) IBOutlet UILabel *durationDisplay;
@property (strong, nonatomic) IBOutlet UILabel *distanceDisplay;
- (IBAction)patrolControl:(id)sender;
@property (strong, nonatomic) IBOutlet UILabel *patrolControlLabel;
@property (strong, nonatomic) IBOutlet UIButton *patrolControlButton;

@property (weak, nonatomic) IBOutlet MKMapView *mapView;
//@property (nonatomic, strong) CLLocationManager *locationManager;
@property (nonatomic, strong) CrumbPath *crumbs;
@property (nonatomic, strong) CrumbPathView *crumbView;
@property (strong, nonatomic) IBOutlet UILabel *timeDisplay; //To remove

- (IBAction)makeReport:(id)sender;

@property (strong, nonatomic) IBOutlet UIButton *reportButton;
@property (strong, nonatomic) IBOutlet UIButton *startStopButton;


@property (strong, nonatomic) IBOutlet UIView *postPatrolDisplay;
- (IBAction)postPatrolButton:(id)sender;
@property (strong, nonatomic) IBOutlet UILabel *postPatrolMessage;

@property (nonatomic) CLLocationDistance sum;
@property (nonatomic) NSMutableArray *location_array;
@property (nonatomic) NSThread *thread;
@property (nonatomic) BOOL start;
@property (nonatomic) int cache_number;
@property (nonatomic) int report_id;
@property (nonatomic) NSString* username;
@property (nonatomic) NSString* start_time;
@property (nonatomic, strong) ConnectionDataController *connectionManager;
@property (nonatomic) NSInteger patrolID;
@property (nonatomic) Timer *timer;
@property (nonatomic, strong) NSTimer *clock;
//Distance of patrol
@property (nonatomic) CLLocation *start_location;
@property (nonatomic) CLLocation *final_location;
@property (nonatomic) NSString *current_location;

@property (nonatomic) NSInteger displayedTime;

//From .m
//CLLocationManager *locationManager;
//CLGeocoder *geocoder;
//CLPlacemark *placemark;
//@property (nonatomic, strong) CLGeocoder *geocoder;
//@property (nonatomic, strong) CLPlacemark *placemark;

-(void) updateLabels;

@end
