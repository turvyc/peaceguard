//
//  StatisticsViewController.m
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-03-10.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "StatisticsViewController.h"

@interface StatisticsViewController ()

@end

@implementation StatisticsViewController

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
    NSLog(self.username);
    self.connectionManager = [[ConnectionDataController alloc] init];
    NSDictionary *statsDictionary = [self.connectionManager getStatistics:self.username andTimePeriod:@"allTime"];
    self.totalPatrolsField.text = [[statsDictionary objectForKey:@"total"] objectForKey:@"patrol"];
    self.totalDistanceField.text = [[statsDictionary objectForKey:@"total"] objectForKey:@"distance"];
    NSLog(@"distance is :%@",self.totalDistanceField.text);
    self.numberOfIncidentsField.text = [[statsDictionary objectForKey:@"total"] objectForKey:@"report"];
    self.totalTimeField.text =  [[statsDictionary objectForKey:@"total"] objectForKey:@"time"];
    //self.totalPatrolsField.text = [statsDictionary objectForKey:@"total"];
    
    self.statDurationPickerview.showsSelectionIndicator = TRUE;
    self.statDurationPickerview.delegate = self;
    
    self.durationData = @"last day";
    
    self.durationSelection = [[NSArray alloc] initWithObjects:@"last day", @"last month", @"last year", @"total", nil];
    
#pragma mark BackgroundCode
    self.view.backgroundColor = [UIColor colorWithPatternImage:[UIImage imageNamed:@"0.jpg"]];
#pragma mark -
    
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (NSInteger)pickerView:(UIPickerView *)pickerView numberOfRowsInComponent:(NSInteger)component{
    
    return [self.durationSelection count];
    
}

//number of columns/components of picker
-(NSInteger)numberOfComponentsInPickerView:(UIPickerView *)pickerView{
    
    return 1;
    
}

-(NSString *)pickerView:(UIPickerView *)pickerView titleForRow:(NSInteger)row forComponent:(NSInteger)component{
    
    return [self.durationSelection objectAtIndex:row];
    
}

//returns value from pickerview
-(void)pickerView:(UIPickerView *)pickerView didSelectRow:(NSInteger)row inComponent:(NSInteger)component{
    
    self.durationData = [self.durationSelection objectAtIndex:row];
    
}


- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
