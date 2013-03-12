//
//  LocationViewController.h
//  peaceguard
//
//  Created by JonasYao on 2013-03-10.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//
#import <CoreLocation/CoreLocation.h>
#import <UIKit/UIKit.h>

@interface LocationViewController : UIViewController <CLLocationManagerDelegate>
- (IBAction)GenerateLocation:(id)sender;
@property (weak, nonatomic) IBOutlet UITextField *Address;
@property (nonatomic) CLLocationDistance sum;
@property (nonatomic) NSMutableArray *myArray;
@property (nonatomic) NSThread *thread;
- (IBAction)StopPatrol:(id)sender;
@end
