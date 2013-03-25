//
//  StatisticsViewController.h
//
//  Contributor(s): Ashley Lesperance, Jonas Yao, Robert Sanchez
//
//  Copyright (c) 2013 Number 123 Developer's Group
//

#import <UIKit/UIKit.h>
#import "ConnectionDataController.h"

@interface StatisticsViewController : UIViewController
@property (nonatomic) int num_of_patrol;
@property (nonatomic) int total_distance;
@property (nonatomic) int total_time;
@property (nonatomic) int total_report;
@property(nonatomic) NSString *username;
@property (strong, nonatomic) ConnectionDataController *connectionManager;
@property (weak, nonatomic) IBOutlet UITextField *totalPatrolsField;
@property (weak, nonatomic) IBOutlet UITextField *totalTimeField;
@property (weak, nonatomic) IBOutlet UITextField *totalDistanceField;
@property (weak, nonatomic) IBOutlet UITextField *numberOfIncidentsField;

- (IBAction)statToBadge:(id)sender;

@property (strong, nonatomic) IBOutlet UIPickerView *statDurationPickerview;
//durationPickerview variables
@property (strong, nonatomic) NSArray *durationSelection;
@property (strong, nonatomic) NSString *durationData;
- (void) updateStatsFor: (NSString *)timePeriod;

@end
